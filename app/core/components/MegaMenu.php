<?php

namespace app\core\components;

use app\core\base\AppModule;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\base\InvalidParamException;
use yii\helpers\ArrayHelper;

/**
 * Class MegaMenu
 * @package app\core\components
 * @property array $items
 * @property-read array $activeItem
 */
class MegaMenu extends Component {

    private $_items = [];
    private $_activeItem;
    private $isModulesFetched = false;

    /**
     * @param array $items
     */
    public function setItems(array $items) {
        $this->addItems($items);
    }

    /**
     * @return array
     */
    public function getItems() {
        if ($this->isModulesFetched === false) {
            $this->isModulesFetched = true;

            // Fetch items from modules
            foreach (\Yii::$app->getModules() as $id => $module) {
                /** @var AppModule $module */
                $module = \Yii::$app->getModule($id);
                if ($module instanceof AppModule) {
                    $this->addItems($module->coreMenus(), false);
                }
            }
        }

        // Find active item
        return $this->fillState($this->_items);
    }

    /**
     * @param array $items
     * @param bool|true $append
     */
    public function addItems(array $items, $append = true) {
        $this->_items = $append ?
            ArrayHelper::merge($this->_items, $items) :
            ArrayHelper::merge($items, $this->_items);
    }

    public function getActiveItem() {
        if ($this->_activeItem === null) {

            // Set active item
            list($route, $params) = \Yii::$app->urlManager->parseRequest(\Yii::$app->request);
            $this->_activeItem = ['/' . $route] + $params;
        }
        return $this->_activeItem;
    }

    /**
     * @param array $fromItem
     * @param array|int $custom Items or level limit
     * @return array
     * @throws InvalidConfigException
     */
    public function getMenu($fromItem = null, $custom = []) {
        if ($fromItem) {
            $fromItem = $this->getItem($fromItem);
            $items = isset($fromItem['items']) ? $fromItem['items'] : [];
        } else {
            $items = $this->getItems();
        }

        // Level limit
        if (is_int($custom)) {
            return $this->sliceTreeItems($items, $custom);
        }

        if (empty($custom)) {
            return $items;
        }

        $menu = [];
        foreach ($custom as $item) {
            $menuItem = $this->getItem($item);

            // Process items
            if (isset($item['items'])) {
                $menuItem['items'] = $this->getMenu($item['items']);
            } else {
                unset($menuItem['items']);
            }

            // Extend item
            $menuItem = array_merge($menuItem, $item);

            $menu[] = $menuItem;
        }
        return $menu;
    }

    /**
     * Get page title as breadcrumbs labels + site name
     * @param array|null $url Child url or route, default - current route
     * @param string $separator Separator, default is " - "
     * @return string
     */
    public function getTitle($url = null, $separator = ' — ') {
        $title = [];
        foreach (array_reverse($this->getBreadcrumbs($url)) as $item) {
            $title[] = $item['label'];
        }
        $title[] = \Yii::$app->name;
        return implode($separator, $title);
    }

    /**
     * Get items for Breadcrumbs widget
     * @param array|null $url Child url or route, default - current route
     * @return array
     */
    public function getBreadcrumbs($url = null) {
        $url = $url ?: $this->getActiveItem();

        // Find child and it parents by url
        $item = $this->getItem($url, $parents);

        if (empty($parents) && $this->isHomeUrl($item['url'])) {
            return [];
        }

        unset($item['items']);
        $parents = array_reverse((array) $parents);
        $parents[] = $item;

        return $parents;
    }

    /**
     * Find item in menu tree
     * @param string|array $item
     * @param array $parents
     * @return array
     * @throws InvalidConfigException
     */
    public function getItem($item, &$parents = []) {
        $url = is_array($item) && !$this->isRoute($item) ?
            $item['url'] :
            $item;

        $item = $this->findItemRecursive($url, $this->getItems(), $parents);
        if ($item === null) {
            throw new InvalidConfigException("Not found item " . var_export($url, true) . "");
        }

        return $item;
    }

    /**
     * @param array $items
     * @param int $level
     * @return array
     */
    protected function sliceTreeItems(array $items, $level = 1) {
        if ($level <= 0) {
            return [];
        }

        $menu = [];
        foreach ($items as $item) {
            if (isset($item['items'])) {
                $item['items'] = $this->sliceTreeItems($item['items'], $level - 1);
                if (empty($item['items'])) {
                    $item['items'] = null;
                }
            }
            $menu[] = $item;
        }
        return $menu;
    }

    /**
     * @param string|array $url
     * @param array $items
     * @param array $parents
     * @return array|null
     */
    protected function findItemRecursive($url, array $items, &$parents) {
        foreach ($items as $item) {
            if (!isset($item['url'])) {
                continue;
            }

            if ($this->isUrlEquals($url, $item['url'])) {
                return $item;
            }

            if (isset($item['items'])) {
                $finedItem = $this->findItemRecursive($url, $item['items'], $parents);
                if ($finedItem) {
                    $parentItem = $item;
                    unset($parentItem['items']);
                    $parents[] = $parentItem;
                    return $finedItem;
                }
            }
        }

        return null;
    }

    /**
     * @param string|array $url1
     * @param string|array $url2
     * @return bool
     */
    protected function isUrlEquals($url1, $url2) {
        // Is routes
        if ($this->isRoute($url1) && $this->isRoute($url2)) {
            if (self::normalizeRoute($url1[0]) !== self::normalizeRoute($url2[0])) {
                return false;
            }

            foreach ($url1 as $key => $value) {
                if (is_string($key) && $key !== '#') {
                    if (!isset($url2[$key])) {
                        return false;
                    }

                    if ($value !== null && $url2[$key] !== $value) {
                        return false;
                    }
                }
            }

            return true;
        }

        // Is urls
        if (is_string($url1) && is_string($url2)) {
            return $url1 === $url2;
        }

        return false;
    }

    /**
     * @param string|array $url
     * @return bool
     */
    protected function isHomeUrl($url) {
        if ($this->isRoute($url)) {
            return \Yii::$app->defaultRoute === $url[0];
        }
        return $url === \Yii::$app->homeUrl;
    }

    /**
     * @param array $item
     * @return bool
     */
    protected function isActiveItem($item) {
        $isActive = $this->isUrlEquals($item['url'], $this->getActiveItem());
        if ($isActive) {
            return true;
        }
    }

    /**
     * @param mixed $value
     * @return bool
     */
    protected function isItem($value) {
        return is_array($value) && !$this->isRoute($value);
    }

    /**
     * @param mixed $value
     * @return bool
     */
    protected function isRoute($value) {
        return is_array($value) && isset($value[0]) && is_string($value[0]);
    }

    protected function fillState($items) {
        foreach ($items as &$item) {
            $item['visible'] = self::normalizeVisible($item);

            if (!isset($item['active'])) {
                $item['active'] = $this->isUrlEquals($item['url'], $this->getActiveItem());
            }

            if (isset($item['items'])) {
                $item['items'] = $this->fillState($item['items']);

                foreach ($item['items'] as $subItem) {
                    if ($subItem['active']) {
                        $item['active'] = true;
                        break;
                    }
                }
            }
        }

        return $items;
    }

    protected static function normalizeVisible($item) {
        if (isset($item['visible'])) {
            return $item['visible'];
        }

        if (isset($item['roles'])) {
            foreach ((array) $item['roles'] as $role) {
                if ($role === '?') {
                    if (\Yii::$app->user->getIsGuest()) {
                        return true;
                    }
                } elseif ($role === '@') {
                    if (!\Yii::$app->user->getIsGuest()) {
                        return true;
                    }
                } elseif (\Yii::$app->user->can($role)) {
                    return true;
                }
            }
            return false;
        }

        return true;
    }

    /**
     * Function from class \yii\helpers\BaseUrl
     * @param string $route
     * @return string
     */
    protected static function normalizeRoute($route) {
        $route = \Yii::getAlias((string) $route);
        if (strncmp($route, '/', 1) === 0) {
            // absolute route
            return ltrim($route, '/');
        }

        // relative route
        if (\Yii::$app->controller === null) {
            throw new InvalidParamException("Unable to resolve the relative route: $route. No active controller is available.");
        }

        if (strpos($route, '/') === false) {
            // empty or an action ID
            return $route === '' ? \Yii::$app->controller->getRoute() : \Yii::$app->controller->getUniqueId() . '/' . $route;
        } else {
            // relative to module
            return ltrim(\Yii::$app->controller->module->getUniqueId() . '/' . $route, '/');
        }
    }

}
<?php

namespace app\core\admin\widgets;

use Yii;
use yii\base\InvalidConfigException;
use yii\bootstrap\Nav;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Sidebar menu widget
 */
class SidebarNav extends Nav
{
    /**
     * @inheritdoc
     */
    public $activateParents = true;

    /**
     * @var string
     */
    public $iconTemplate = '<span class="{icon}"></span>';

    /**
     * @var string
     */
    public $defaultIcon = '';

    /**
     * @var bool
     */
    public $showDefaultSubmenuIcon = false;

    public $encodeLabels = false;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->options['class'] = 'nav nav-sidebar';
        if ($this->dropDownCaret === null) {
            $this->dropDownCaret = Html::tag('span', '', ['class' => 'glyphicon glyphicon-chevron-down arrow']);
        }
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function renderItem($item)
    {
        if (is_string($item)) {
            return $item;
        }
        if (!isset($item['label'])) {
            throw new InvalidConfigException("The 'label' option is required.");
        }
        $encodeLabel = isset($item['encode']) ? $item['encode'] : $this->encodeLabels;
        $label = $encodeLabel ? Html::encode($item['label']) : $item['label'];
        $options = ArrayHelper::getValue($item, 'options', []);
        $items = ArrayHelper::getValue($item, 'items');
        $url = ArrayHelper::getValue($item, 'url', '#');
        $linkOptions = ArrayHelper::getValue($item, 'linkOptions', []);
        $icon = ArrayHelper::getValue($item, 'icon', '');

        if (!empty($this->iconTemplate)) {
            if (empty($icon)) {
                $icon = $this->defaultIcon;
            }
            if (!empty($icon)) {
                $label = str_replace('{icon}', $icon, $this->iconTemplate) . ' ' . $label;
            }
        }

        if (isset($item['active'])) {
            $active = ArrayHelper::remove($item, 'active', false);
        } else {
            $active = $this->isItemActive($item);
        }

        if (empty($items)) {
            $items = '';
        } else {
            if (is_array($items)) {
                if ($this->dropDownCaret !== '') {
                    $label .= ' ' . $this->dropDownCaret;
                }
                if ($this->activateItems) {
                    $items = $this->isChildActive($items, $active);
                }
                if ($this->activateItems && $active) {
                    $submenuClass = 'nav';
                } else {
                    $submenuClass = 'nav collapse';
                }
                $items = $this->renderSubmenuItems($items, ['class' => $submenuClass]);
            }
        }

        if ($this->activateItems && $active) {
            Html::addCssClass($options, 'current active');
        }

        return Html::tag('li', Html::a($label, $url, $linkOptions) . $items, $options);
    }

    /**
     * Renders submenu items.
     * @param array $items
     * @param array $options
     * @return string
     * @throws InvalidConfigException
     */
    protected function renderSubmenuItems($items, $options = [])
    {
        $lines = [];
        foreach ($items as $item) {
            if (isset($item['visible']) && !$item['visible']) {
                continue;
            }
            if (is_string($item)) {
                $lines[] = $item;
                continue;
            }
            if (!array_key_exists('label', $item)) {
                throw new InvalidConfigException("The 'label' option is required.");
            }
            $encodeLabel = isset($item['encode']) ? $item['encode'] : $this->encodeLabels;
            $label = $encodeLabel ? Html::encode($item['label']) : $item['label'];
            $itemOptions = ArrayHelper::getValue($item, 'options', []);
            $linkOptions = ArrayHelper::getValue($item, 'linkOptions', []);
            $url = array_key_exists('url', $item) ? $item['url'] : null;
            $icon = ArrayHelper::getValue($item, 'icon', '');

            if (!empty($this->iconTemplate)) {
                if (empty($icon) && $this->showDefaultSubmenuIcon) {
                    $icon = $this->defaultIcon;
                }
                if (!empty($icon)) {
                    $label = str_replace('{icon}', $icon, $this->iconTemplate) . ' ' . $label;
                }
            }

            if ($url === null) {
                $content = $label;
                Html::addCssClass($itemOptions, ['class' => 'sidebar-header']);
            } else {
                $content = Html::a($label, $url, $linkOptions);
            }

            $lines[] = Html::tag('li', $content, $itemOptions);
        }

        return Html::tag('ul', implode("\n", $lines), $options);
    }
}

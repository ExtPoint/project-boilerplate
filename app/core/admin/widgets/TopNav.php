<?php

namespace app\core\admin\widgets;

use Yii;
use yii\base\InvalidConfigException;
use yii\bootstrap\Nav;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Top menu widget
 */
class TopNav extends Nav
{
    /**
     * @var string
     */
    public $iconTemplate = '<i class="{icon}"></i>';

    /**
     * @var string
     */
    public $labelTemplate = '{icon} <span class="hidden-xs">{label}</span>';

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
        $customIcon = ArrayHelper::getValue($item, 'customIcon', '');

        if (!empty($customIcon) && !empty($this->labelTemplate)) {
            $label = str_replace(['{icon}', '{label}'], [$customIcon, $label], $this->labelTemplate);
        } elseif (!empty($this->iconTemplate) && !empty($icon) && !empty($this->labelTemplate)) {
            $label = str_replace(['{icon}', '{label}'], [str_replace('{icon}', $icon, $this->iconTemplate), $label], $this->labelTemplate);
        }

        if (isset($item['active'])) {
            $active = ArrayHelper::remove($item, 'active', false);
        } else {
            $active = $this->isItemActive($item);
        }

        if (empty($items)) {
            $items = '';
        } else {
            $linkOptions['data-toggle'] = 'dropdown';
            Html::addCssClass($options, ['widget' => 'dropdown']);
            Html::addCssClass($linkOptions, ['widget' => 'dropdown-toggle']);
            if ($this->dropDownCaret !== '') {
                $label .= ' ' . $this->dropDownCaret;
            }
            if (is_array($items)) {
                if ($this->activateItems) {
                    $items = $this->isChildActive($items, $active);
                }
                $items = $this->renderDropdown($items, $item);
            }
        }

        if ($this->activateItems && $active) {
            Html::addCssClass($options, 'active');
        }

        return Html::tag('li', Html::a($label, $url, $linkOptions) . $items, $options);
    }
}

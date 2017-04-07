<?php

namespace app\core\widgets;

use app\core\base\AppModel;
use extpoint\megamenu\MenuHelper;
use yii\base\Widget;
use yii\helpers\Html;

class MenuLink extends Widget
{
    /**
     * @var array
     */
    public $url;

    /**
     * @var string
     */
    public $label;

    /**
     * @var string
     */
    public $icon;

    /**
     * @var bool
     */
    public $visible = true;

    /**
     * @var array
     */
    public $options = [];

    public function run()
    {
        // Check widget visible
        if (!$this->visible) {
            return '';
        }

        // Check access via MegaMenu
        $item = \Yii::$app->megaMenu->getItem($this->url);
        if (!$item || !$item->getVisible()) {
            return '';
        }

        $icon = $this->icon ?: $item->icon;
        $label = $this->label ?: $item->label;

        return Html::a(
            ($icon ? "<span class='$icon'></span> " : '') . $label,
            $item->normalizedUrl,
            $this->options
        );
    }
}
<?php

namespace app\core\base;

use extpoint\yii2\base\Widget;
use yii\base\InvalidCallException;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\View;

class AppWidget extends Widget
{
    public function renderReact($config)
    {
        if (!preg_match('/^app\\\\(\\w+)(\\\\admin)?\\\\widgets\\\\(\\w+)\\\\(\\w+)$/', get_class($this), $regs)) {
            throw new InvalidCallException('Widget class name is wrong for ' . get_class($this));
        }

        list(, , , $widgetName) = $regs;
        $jsArgs = [
            Json::encode($this->id),
            Json::encode(get_class($this)),
            !empty($config) ? Json::encode($config) : '{}',
        ];
        $this->view->registerJs('__appWidget.render(' . implode(', ', $jsArgs) . ')', View::POS_END, $this->id);
        $this->view->registerJsFile("@web/assets/bundle-$widgetName.js?t=" . filemtime(__FILE__), ['position' => View::POS_END]);

        return Html::tag('span', '', ['id' => $this->id]);
    }
}

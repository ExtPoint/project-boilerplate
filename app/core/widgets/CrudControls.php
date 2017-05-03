<?php

namespace app\core\widgets;

use app\core\base\AppModel;
use extpoint\megamenu\MenuHelper;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class CrudControls extends Widget
{
    /**
     * @var AppModel|null
     */
    public $model;

    /**
     * @var array
     */
    public $actionParams = [];

    /**
     * @var array
     */
    public $buttons;

    /**
     * @var string
     */
    public $pkParam;

    public function init() {
        $actionId = \Yii::$app->controller->action->id;

        $defaultButtons = [
            'create' => [
                'icon' => 'glyphicon glyphicon-plus',
                'label' => 'Добавить',
                'url' => array_merge(['create'], $this->actionParams),
                'visible' => $actionId === 'index',
                'options' => [
                    'class' => 'btn btn-success',
                ],
            ],
        ];
        if ($this->model) {
            $model = $this->model;
            $pkParam = $this->pkParam ?: $model::getRequestParamName();

            $defaultButtons['index'] = [
                'icon' => 'glyphicon glyphicon-arrow-left',
                'label' => 'К списку',
                'url' => array_merge(['index'], $this->actionParams),
                'visible' => $actionId !== 'index',
                'options' => [
                    'class' => 'btn btn-default',
                ]
            ];
            $defaultButtons['view'] = [
                'label' => 'Просмотр',
                'url' => array_merge(['view', $pkParam => $this->model->primaryKey], $this->actionParams),
                'visible' => in_array($actionId, ['create', 'update']) && !$this->model->isNewRecord && $this->model->canView(\Yii::$app->user->model),
                'options' => [
                    'class' => 'btn btn-default',
                ],
            ];
            $defaultButtons['update'] = [
                'label' => 'Редактировать',
                'url' => array_merge(['update', $pkParam => $this->model->primaryKey], $this->actionParams),
                'visible' => $actionId === 'view' && $this->model->canUpdate(\Yii::$app->user->model),
                'options' => [
                    'class' => 'btn btn-warning',
                ],
            ];
            $defaultButtons['delete'] = [
                'icon' => 'glyphicon glyphicon-remove',
                'label' => 'Удалить',
                'url' => array_merge(['delete', $pkParam => $this->model->primaryKey], $this->actionParams),
                'position' => 'right',
                'visible' => $actionId !== 'index' && $this->model->canDelete(\Yii::$app->user->model),
                'options' => [
                    'class' => 'btn btn-danger',
                    'data-confirm' => 'Удалить запись?',
                    'data-method' => 'post',
                ],
            ];
        }

        foreach ($defaultButtons as $key => $item) {
            if (!isset($this->buttons[$key])) {
                $this->buttons[$key] = [];
            }
            $this->buttons[$key] = array_merge($item, $this->buttons[$key]);
        }
    }

    public function run()
    {
        $leftButtons = [];
        foreach ($this->buttons as $button) {
            $position = ArrayHelper::remove($button, 'position');
            if ($position !== 'right') {
                $leftButtons[] = MenuLink::widget($button);
            }
        }

        $rightButtons = [];
        foreach ($this->buttons as $button) {
            $position = ArrayHelper::remove($button, 'position');
            if ($position === 'right') {
                $rightButtons[] = MenuLink::widget($button);
            }
        }

        return implode("\n", $leftButtons)
            . Html::tag('div', implode("\n", $rightButtons), ['class' => 'pull-right']);
    }
}
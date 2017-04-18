<?php

namespace app\core\widgets;

use Yii;
use alexantr\datetimepicker\DateTimePicker;
use app\core\base\AppModel;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Url;

class AppGridView extends GridView
{
    public $tableOptions = ['class' => 'table table-hover'];

    public $layout = "<div class='table-responsive'>{items}</div>\n{pager}";

    /**
     * @var array
     */
    public $actions = [];

    /**
     * @var array
     */
    public $actionParams = [];

    /**
     * @var string
     */
    public $pkParam;

    protected function guessColumns()
    {
        if ($this->dataProvider instanceof ActiveDataProvider
            && $this->dataProvider->query instanceof ActiveQuery) {
            /** @var ActiveQuery $query */
            $query = $this->dataProvider->query;

            /** @var AppModel $modelClass */
            $modelClass = $query->modelClass;

            foreach ($modelClass::meta() as $attribute => $item) {
                if (!empty($item['showInTable'])) {
                    $this->columns[] = [
                        'attribute' => $attribute,
                        'label' => $item['label'],
                        'format' => !empty($item['formatter']) ? $item['formatter'] : 'text',
                    ];
                }
            }
        } else {
            parent::guessColumns();
        }
    }

    protected function initColumns()
    {
        parent::initColumns();

        if (!empty($this->actions)) {
            $buttons = [];
            $templateButtons = [];

            foreach ($this->actions as $name => $action) {
                if (is_string($action)) {
                    $templateButtons[] = $action;
                } else {
                    $templateButtons[] = $name;
                    $buttons[$name] = $action;
                }
            }

            $this->columns[] = Yii::createObject([
                'class' => ActionColumn::className(),
                'grid' => $this,
                'template' => '{' . implode('} {', $templateButtons) . '}',
                'buttons' => $buttons,
                'urlCreator' => function($action, $model) {
                    /** @type AppModel $model */
                    $pkParam = $this->pkParam ?: $model::getRequestParamName();

                    return Url::to(array_merge([$action, $pkParam => $model->primaryKey], $this->actionParams));
                },
                'visibleButtons' => [
                    'view' => function($model) {
                        /** @type AppModel $model */
                        $pkParam = $this->pkParam ?: $model::getRequestParamName();
                        $url = array_merge(['view', $pkParam => $model->primaryKey], $this->actionParams);

                        return \Yii::$app->megaMenu->isAllowAccess($url) && $model->canView(Yii::$app->user->model);
                    },
                    'update' => function($model) {
                        /** @type AppModel $model */
                        $pkParam = $this->pkParam ?: $model::getRequestParamName();
                        $url = array_merge(['update', $pkParam => $model->primaryKey], $this->actionParams);

                        return \Yii::$app->megaMenu->isAllowAccess($url) && $model->canUpdate(Yii::$app->user->model);
                    },
                    'delete' => function($model) {
                        /** @type AppModel $model */
                        $pkParam = $this->pkParam ?: $model::getRequestParamName();
                        $url = array_merge(['delete', $pkParam => $model->primaryKey], $this->actionParams);

                        return \Yii::$app->megaMenu->isAllowAccess($url) && $model->canDelete(Yii::$app->user->model);
                    },
                ],
            ]);
        }
    }
}
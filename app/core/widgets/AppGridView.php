<?php

namespace app\core\widgets;

use alexantr\datetimepicker\DateTimePicker;
use app\core\base\AppModel;
use yii\bootstrap\ActiveField;
use kartik\widgets\DatePicker;
use dosamigos\ckeditor\CKEditor;
use yii\bootstrap\Html;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

class AppGridView extends GridView
{
    public $tableOptions = ['class' => 'table table-hover'];

    public $layout = "<div class='table-responsive'>{items}</div>\n{pager}";

    public $actions = [];

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
            if (!empty($this->actions)) {
                $this->columns[] = [
                    'class' => ActionColumn::className(),
                    'template' => '{' . implode('} {', $this->actions) . '}',
                    'visibleButtons' => [
                        'view' => function($model) {
                            $item = \Yii::$app->megaMenu->getItem(['view', 'id' => $model->id]);
                            return $item && $item->getVisible();
                        },
                        'update' => function($model) {
                            $item = \Yii::$app->megaMenu->getItem(['update', 'id' => $model->id]);
                            return $item && $item->getVisible();
                        },
                        'delete' => function($model) {
                            $item = \Yii::$app->megaMenu->getItem(['delete', 'id' => $model->id]);
                            return $item && $item->getVisible();
                        },
                    ],
                ];
            }
        } else {
            parent::guessColumns();
        }
    }
}
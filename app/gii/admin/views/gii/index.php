<?php

namespace app\views;

use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $modelDataProvider ArrayDataProvider */

?>

<div class="row">
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Создание модуля
                </h3>
            </div>
            <div class="panel-body">
                <?= Html::beginForm() ?>
                    <div class="form-group">
                        <?= Html::textInput('moduleId', '', [
                            'class' => 'form-control',
                            'placeholder' => 'Module ID',
                        ]) ?>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="create-module" class="btn btn-default">Создать</button>
                    </div>
                <?= Html::endForm() ?>
            </div>
        </div>
    </div>
    <div class="col-md-4">

    </div>
    <div class="col-md-4">

    </div>
</div>

<h3>Models</h3>
<?= GridView::widget([
    'dataProvider' => $modelDataProvider,
    'columns' => [
        'module',
        [
            'attribute' => 'name',
            'format' => 'raw',
            'value' => function($model) {
                return Html::a($model['name'], ['/gii/admin/gii/model', 'moduleId' => $model['module'], 'modelName' => $model['name']]);
            }
        ],
        'metaName',
        'tableName',
        [
            'format' => 'raw',
            'value' => function($model) {
                return Html::a('<span class="glyphicon glyphicon-plus"></span> CRUD', ['/gii/admin/gii/crud', 'moduleId' => $model['module'], 'modelName' => $model['name']]);
            }
        ]
    ],
]) ?>


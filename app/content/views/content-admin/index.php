<?php

namespace app\views;

use app\content\enums\ContentType;
use app\content\models\Content;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this \yii\web\View */
/* @var $searchModel \app\content\forms\ContentSearch */
/* @var $dataProvider \yii\data\ActiveDataProvider */

?>
<div class="content-index">

    <h1><?= ContentType::getLabel($searchModel->type) ?></h1>

    <p>
        <?= Html::a('Добавить', ['create', 'type' => $searchModel->type], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'title',
            'name',
            'isPublished:boolean',
            'createTime:dateTime',
            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        /** @type Content $model */
                        return Html::a(
                            '<span class="glyphicon glyphicon-eye-open"></span>',
                            ['/content/content/view', 'type' => ContentType::NEWS, 'uid' => $model->uid]
                        );
                    },
                    'update' => function ($url, $model, $key) {
                        /** @type Content $model */
                        return Html::a(
                            '<span class="glyphicon glyphicon-pencil"></span>',
                            ['/content/content-admin/update', 'type' => ContentType::NEWS, 'uid' => $model->uid]
                        );
                    },
                ]
            ],
        ],
    ]); ?>

</div>

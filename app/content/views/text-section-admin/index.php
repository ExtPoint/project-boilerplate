<?php

namespace app\views;

use app\content\models\TextSection;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this \yii\web\View */
/* @var $searchModel \app\content\forms\TextSectionSearch */
/* @var $dataProvider \yii\data\ActiveDataProvider */

?>

<h1><?= Html::encode($this->title) ?></h1>
<p>
    <?= Html::a(\Yii::t('app', 'Добавить'), ['/content/text-section-admin/update'], ['class' => 'btn btn-success']) ?>
</p>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'title',
        'name',
        'isPublished:boolean',
        'updateTime:dateTime',
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update} {delete}',
            'buttons' => [
                'update' => function ($url, $model, $key) {
                    /** @type TextSection $model */
                    return Html::a(
                        '<span class="glyphicon glyphicon-pencil"></span>',
                        ['/content/text-section-admin/update', 'uid' => $model->uid]
                    );
                },
            ]
        ],
    ],
]); ?>

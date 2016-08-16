<?php

namespace app\views;

use app\content\models\Page;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $searchModel \app\content\forms\PageSearch */
/* @var $dataProvider \yii\data\ActiveDataProvider */

?>

<h1><?= Html::encode($this->title) ?></h1>
<p>
    <?= Html::a(\Yii::t('app', 'Добавить'), ['/content/page-admin/update'], ['class' => 'btn btn-success']) ?>
</p>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'title',
        'name',
        [
            'label' => 'Адрес',
            'format' => 'raw',
            'value' => function ($model) {
                $url = Url::toRoute(['/content/page/view', 'uid' => $model->uid]);
                return Html::a(ltrim($url, '/'), $url);
            },
        ],
        'isPublished:boolean',
        'updateTime:dateTime',
        [
            'class' => 'yii\grid\ActionColumn',
            'buttons' => [
                'view' => function ($url, $model, $key) {
                    /** @type Page $model */
                    return Html::a(
                        '<span class="glyphicon glyphicon-eye-open"></span>',
                        ['/content/page/view', 'uid' => $model->uid]
                    );
                },
                'update' => function ($url, $model, $key) {
                    /** @type Page $model */
                    return Html::a(
                        '<span class="glyphicon glyphicon-pencil"></span>',
                        ['/content/page-admin/update', 'uid' => $model->uid]
                    );
                },
            ]
        ],
    ],
]); ?>

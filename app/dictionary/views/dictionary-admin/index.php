<?php

namespace app\views;

use Yii;
use yii\web\View;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use app\dictionary\forms\DictionarySearch;

/* @var View $this */
/* @var DictionarySearch $dictionarySearchModel */
/* @var ActiveDataProvider $dataProvider */

?>

<h1><?= Html::encode($this->title) ?></h1>
<p>
    <?= Html::a('Добавить', ['update'], ['class' => 'btn btn-success']) ?>
</p>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $dictionarySearchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'type',
        'name',
        'title',
        'createTime',
        'updateTime',

        ['class' => 'yii\grid\ActionColumn'],
    ],
]); ?>

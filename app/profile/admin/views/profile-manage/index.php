<?php

namespace app\views;

use app\core\models\User;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this \yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $searchModel \app\profile\forms\UserSearch */
/* @var $form \app\core\widgets\AppActiveForm */

?>
<h1><?= Html::encode($this->title) ?></h1>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'name',
        'email',

        [
            'class' => ActionColumn::className(),
            'template' => '{view} {update}',
            'urlCreator' => function($action, $model, $key, $index) {
                /** @type User $model */
                switch ($action) {
                    case 'view':
                        return ['/profile/profile/view', 'userId' => $model->id];
                    case 'update':
                        return ['/profile/profile-edit/index', 'userId' => $model->id];
                }
                return '#';
            }
        ],
    ],
]); ?>

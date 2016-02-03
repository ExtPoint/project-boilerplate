<?php

namespace app\views;

use app\core\models\User;
use app\profile\enums\UserRole;
use yii\bootstrap\ActiveForm;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this \yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $searchModel \app\profile\forms\UserSearch */
/* @var $form \yii\widgets\ActiveForm */

?>
<h1><?= Html::encode($this->title) ?></h1>

<?php /*$form = ActiveForm::begin([
    'action' => ['/profile/profile-admin/index'],
    'method' => 'get',
    'layout' => 'horizontal',
]); ?>

<?= $form->field($searchModel, 'email') ?>
<?= $form->field($searchModel, 'name') ?>
<?= $form->field($searchModel, 'role')->dropDownList(['' => ''] + UserRole::getLabels()) ?>

<div class="form-group">
    <div class="col-lg-offset-3 col-lg-9">
        <?= Html::submitButton('Найти', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Сбросить', ['class' => 'btn btn-default']) ?>
    </div>
</div>

<?php ActiveForm::end();*/ ?>


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
                        return ['/profile/profile/view', 'userUid' => $model->uid];
                    case 'update':
                        return ['/profile/profile-edit/index', 'userUid' => $model->uid];
                }
                return '#';
            }
        ],
    ],
]); ?>


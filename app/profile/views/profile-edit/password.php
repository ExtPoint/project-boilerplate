<?php

namespace app\views;

use yii\bootstrap\Nav;
use yii\helpers\Html;
use app\core\widgets\AppActiveForm;

/* @var $this \yii\web\View */
/* @var $model \app\profile\forms\PasswordUpdate */
?>

<h1>Редактирование профиля</h1>
<?= Nav::widget([
    'options' => ['class' => 'nav-tabs'],
    'items' => \Yii::$app->megaMenu->getMenu(['/profile/profile-edit/index'], 1),
]); ?>
<br />

<?php $form = AppActiveForm::begin(); ?>

<?= $form->field($model, 'oldPassword')->passwordInput(['maxlength' => true]) ?>
<?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
<?= $form->field($model, 'passwordAgain')->passwordInput(['maxlength' => true]) ?>

<div class="form-group">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
</div>

<?php AppActiveForm::end(); ?>

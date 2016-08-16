<?php

namespace app\views;

use app\file\widgets\fileup\FileInput;
use kartik\widgets\DatePicker;
use app\core\widgets\AppActiveForm;
use yii\bootstrap\Nav;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $model \app\core\models\User */
?>

<h1>Редактирование профиля</h1>
<?= Nav::widget([
    'options' => ['class' => 'nav-tabs'],
    'items' => \Yii::$app->megaMenu->getMenu(['/profile/profile-edit/index', 'userUid' => $model->uid], 1),
]); ?>

<div class="col-lg-7">
    <?php $form = AppActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
        'layout' => 'horizontal',
    ]); ?>

    <h3>Основное</h3>
    <?= $form->field($model->info, 'firstName') ?>
    <?= $form->field($model->info, 'lastName') ?>
    <?= $form->field($model, 'email', [
        'inputTemplate' => '<div class="input-group"><span class="input-group-addon">@</span>{input}</div>',
    ]) ?>
    <?= $form->field($model->info, 'phone', [
        'inputTemplate' => '<div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-phone"></span></span>{input}</div>',
    ]) ?>
    <?= $form->field($model->info, 'birthday')->widget(DatePicker::classname()) ?>

    <h3>Смена фотографии</h3>
    <?= $form->field($model, 'photo')->widget(FileInput::className()) ?>

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-6">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>

    <?php AppActiveForm::end(); ?>
</div>
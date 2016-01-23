<?php

namespace app\views;

use app\file\widgets\fileup\FileInput;
use kartik\widgets\DatePicker;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Nav;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $model \app\core\models\User */
?>

<h1>Редактирование профиля</h1>
<?= Nav::widget([
    'options' => ['class' => 'nav-tabs'],
    'items' => \Yii::$app->megaMenu->getMenu(['/profile/profile-edit/index'], 1),
]); ?>

<div class="col-lg-7">
    <?php $form = ActiveForm::begin([
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
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
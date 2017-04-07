<?php

namespace app\views;

use app\auth\AuthModule;
use app\auth\models\SocialConnection;
use yii\authclient\widgets\AuthChoice;
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
    'items' => \Yii::$app->megaMenu->getMenu(['/profile/profile-edit/index', 'userId' => $model->id], 1),
]); ?>

<div class="col-lg-7">
    <?php $form = AppActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
        'layout' => 'horizontal',
    ]); ?>

    <h3>Основное</h3>
    <?= $form->field($model, 'firstName') ?>
    <?= $form->field($model, 'lastName') ?>
    <?= $form->field($model, 'email', [
        'inputTemplate' => '<div class="input-group"><span class="input-group-addon">@</span>{input}</div>',
    ]) ?>
    <?= $form->field($model, 'phone', [
        'inputTemplate' => '<div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-phone"></span></span>{input}</div>',
    ]) ?>
    <?= $form->field($model, 'birthday')->widget(DatePicker::classname()) ?>

    <h3>Смена фотографии</h3>
    <?= $form->field($model, 'photo')->file() ?>

    <?php if(AuthModule::getInstance()->enableSocial): ?>
        <h3>Добавить авторизацию через соц сеть</h3>
        <?php $authAuthChoice = AuthChoice::begin([
            'baseAuthUrl' => ['/auth/auth/social'],
            'popupMode' => false,
            'clients' => AuthModule::getInstance()->authClientCollection->getClients(),
        ]); ?>
        <ul class='auth-clients'>
            <?php foreach ($authAuthChoice->getClients() as $client): ?>
                <li class='bg-success text-success'>
                    <?= $authAuthChoice->clientLink($client) ?>
                    <?php if(SocialConnection::findOne([
                        'source' => $client->getId(),
                        'userId' => \Yii::$app->user->id,
                    ])): ?>
                        <span>✓</span>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
        <?php AuthChoice::end(); ?>
    <?php endif; ?>

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-6">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>

    <?php AppActiveForm::end(); ?>
</div>
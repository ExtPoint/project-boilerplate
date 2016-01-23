<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\BaseMessage */
/* @var $user \app\core\models\User */

$message->setSubject('Добро пожаловать на сайт ' . \Yii::$app->name);

?>
<h2>Добро пожаловать!</h2>
<p>Вы успешно зарегистрировались на сайте <strong><?= Html::a(Yii::$app->name, Url::home(true))?></strong>.</p>
<p>Ваш логин: <?= Html::encode($user->email); ?></p>

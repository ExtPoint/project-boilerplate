<?php

/* @var $this \yii\web\View */
/* @var $message \yii\mail\BaseMessage */
/* @var $url string */
/* @var $user \app\core\models\User */

$message->setSubject(\Yii::$app->name . ' - Восстановление доступа');

?>
<h2>Восстановление пароля!</h2>
Логин: <?= \yii\helpers\Html::encode($user->email) ?>
<br />Для восстановления доступа к своему аккаунту, пожалуйста, пройдите по ссылке: <?= \yii\helpers\Html::a($url, $url); ?>
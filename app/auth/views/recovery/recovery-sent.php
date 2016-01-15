<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $email string password recovery instructions was send to that e-mail */

$this->title = 'Восстановление пароля';
?>
<div class="m-auth">

	<h1><?= Html::encode($this->title) ?></h1>

	<p>На e-mail <strong><?= Html::encode($email) ?></strong> отправленно письмо с инструкциями по восстановлению пароля. </p>

</div>
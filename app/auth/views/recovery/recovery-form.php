<?php
use yii\helpers\Html;
use app\core\widgets\AppActiveForm;
use yii\captcha\Captcha;

/* @var $this yii\web\View */
/* @var $form app\core\widgets\AppActiveForm */
/* @var $model app\auth\models\PasswordRecoveryKeyForm */

$this->title = 'Восстановление пароля';
?>
<div class="m-auth">

	<h1><?= Html::encode($this->title) ?></h1>

	<?php $form = AppActiveForm::begin(); ?>
	<?= $form->field($model, 'email')->textInput(['type' => 'email']) ?>
	<?= $form->field($model, 'captcha')->widget(Captcha::className(), [
		'captchaAction' => '/auth/recovery/captcha',
	]) ?>

	<div class="form-group">
		<div class="">
			<?= Html::submitButton('Восстановить', ['class' => 'btn btn-primary']) ?>
		</div>
	</div>

	<?php AppActiveForm::end(); ?>

</div>
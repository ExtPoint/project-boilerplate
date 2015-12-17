<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\auth\models\PasswordRecoveryKeyForm */

$this->title = 'Восстановление пароля';
?>
<div class="m-auth">

	<h1><?= Html::encode($this->title) ?></h1>

	<?php $form = ActiveForm::begin(); ?>
	<?= $form->field($model, 'email')->textInput(['type' => 'email']) ?>
	<?= $form->field($model, 'captcha')->widget(Captcha::className(), [
		'captchaAction' => '/auth/recovery/captcha',
	]) ?>

	<div class="form-group">
		<div class="">
			<?= Html::submitButton('Восстановить', ['class' => 'btn btn-primary']) ?>
		</div>
	</div>

	<?php ActiveForm::end(); ?>

</div>
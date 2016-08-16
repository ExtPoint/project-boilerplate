<?php
use yii\helpers\Html;
use app\core\widgets\AppActiveForm;

/* @var $this yii\web\View */
/* @var $form app\core\widgets\AppActiveForm */
/* @var $model app\auth\models\PasswordResetForm */

$this->title = 'Восстановление пароля';
?>
<div class="m-auth">

	<h1><?= Html::encode($this->title) ?></h1>

	<?php $form = AppActiveForm::begin(); ?>
	<?= $form->field($model, 'password')->passwordInput() ?>
	<?= $form->field($model, 'passwordAgain')->passwordInput() ?>

	<div class="form-group">
		<div class="">
			<?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
		</div>
	</div>

	<?php AppActiveForm::end(); ?>

</div>
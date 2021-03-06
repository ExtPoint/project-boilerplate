<?php

namespace app\views;

use app\auth\AuthModule;
use app\auth\models\LoginForm;
use yii\authclient\widgets\AuthChoice;
use yii\helpers\Html;
use app\core\widgets\AppActiveForm;
use yii\web\View;

/* @var $this View */
/* @var $form AppActiveForm */
/* @var $model LoginForm */

$this->title = 'Вход';
?>
<div class="m-auth">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = AppActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'default',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>
    <?= $form->field($model, 'username')->textInput(['type' => 'email']) ?>
    <?= $form->field($model, 'password')->passwordInput() ?>

	<div class="row">
		<div class="col-lg-3 col-lg-offset-1">
			<?= Html::a('Забыли пароль?', ['/auth/recovery/index']) ?>
		</div>
	</div>

    <div class="col-lg-3 col-lg-offset-1">
        <?= $form->field($model, 'rememberMe', [
            'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
        ])->checkbox() ?>
    </div>

    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('Войти', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>

    <?php if (AuthModule::getInstance()->enableSocial) { ?>
        <?= AuthChoice::widget([
            'baseAuthUrl' => ['/auth/auth/social'],
            'popupMode' => false,
        ]) ?>
    <?php } ?>

    <?php AppActiveForm::end(); ?>

</div>

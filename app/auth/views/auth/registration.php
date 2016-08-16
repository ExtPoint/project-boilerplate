<?php

use yii\helpers\Html;
use app\core\widgets\AppActiveForm;

/* @var $this yii\web\View */
/* @var $form app\core\widgets\AppActiveForm */
/* @var $model app\auth\models\RegistrationForm */

$this->title = 'Регистрация';
?>
<div class="m-auth">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = AppActiveForm::begin([
        'id' => 'login-form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-7\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-2 control-label registrationFormLabel'],
        ],
    ]); ?>

    <?= $form->field($model, 'name') ?>
    <?= $form->field($model, 'email')->input('email') ?>
    <?= $form->field($model, 'password')->passwordInput() ?>

    <?= $form->field($model, 'agreementAccepted', [
        'template' => '<div class="col-lg-5 col-lg-offset-2">{input}<span> Я принимаю условия '
            . Html::a('пользовательского соглашения', ['/auth/auth/agreement'], ['target' => '_blank']) .
            '</span>{error}</div>',
    ])->checkbox([], false) ?>

    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>

    <script type="application/javascript">
        $(function() {
            $('input[name=agreementAccepted]').change(function() {
                var $checkbox = $(this);
                $checkbox.parents('form').find('input[type=submit]').prop('disabled', !$checkbox.is(':checked'));
            });
        });
    </script>

    <?php AppActiveForm::end(); ?>

</div>
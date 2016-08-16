<?php

namespace app\views;

use yii\bootstrap\Html;
use app\core\widgets\AppActiveForm;
use app\core\widgets\TreeDropdownWidget;
use dosamigos\ckeditor\CKEditor;

/* @var $this \yii\web\View */
/* @var $model \app\content\models\Page */

?>

<h1><?= Html::encode($this->title) ?></h1>

<?php $form = AppActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-7">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'metaKeywords')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'metaDescription')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-5">
            <?= $form->field($model, 'isPublished')->checkbox() ?>
        </div>
    </div>
    <?= $form->field($model, 'text')->widget(CKEditor::className()) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? \Yii::t('app', 'Добавить') : \Yii::t('app', 'Сохранить'), ['class' => 'btn btn-primary']) ?>
    </div>

<?php AppActiveForm::end(); ?>


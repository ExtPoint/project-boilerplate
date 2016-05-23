<?php

namespace app\views;

use app\content\enums\ContentCategory;
use app\file\widgets\fileup\FileInput;
use dosamigos\ckeditor\CKEditor;
use kartik\widgets\DateTimePicker;
use app\core\widgets\AppActiveForm;
use yii\bootstrap\Html;

/* @var $this \yii\web\View */
/* @var $model \app\content\models\Article */

?>

<h1><?= Html::encode($this->title) ?></h1>

<?php $form = AppActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-7">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'category')->dropDownList(['' => ''] + ContentCategory::getLabels()) ?>
        </div>
        <div class="col-md-5">
            <?= $form->field($model, 'publishTime')->widget(DateTimePicker::classname()); ?>
            <?= $form->field($model, 'image')->widget(FileInput::className()); ?>
            <?= $form->field($model, 'isPublished')->checkbox() ?>
        </div>
    </div>
    <?= $form->field($model, 'previewText')->widget(CKEditor::className()) ?>
    <?= $form->field($model, 'text')->widget(CKEditor::className()) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? \Yii::t('app', 'Добавить') : \Yii::t('app', 'Сохранить'), ['class' => 'btn btn-primary']) ?>
    </div>

<?php AppActiveForm::end(); ?>


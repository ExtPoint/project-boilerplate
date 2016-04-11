<?php

namespace app\views;

use app\content\enums\ContentCategory;
use app\content\enums\ContentType;
use app\file\widgets\fileup\FileInput;
use dosamigos\ckeditor\CKEditor;
use kartik\widgets\DatePicker;
use kartik\widgets\DateTimePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this \yii\web\View */
/* @var $model \app\content\models\Content */
/* @var $form \yii\widgets\ActiveForm */
?>

<div class="content-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <?= $form->field($model, 'type')->hiddenInput()->label(false) ?>

    <div class="row">
        <div class="col-md-7">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?php
            if ($model->hasAttribute('category')) {
                echo $form->field($model, 'category')->dropDownList(['' => ''] + ContentCategory::getLabels());
            }
            ?>
        </div>
        <div class="col-md-5">
            <?php
            if ($model->hasAttribute('publishTime')) {
                echo $form->field($model, 'publishTime')->widget(DateTimePicker::classname());
            }
            ?>
            <?php
            if ($model->hasAttribute('image')) {
                echo $form->field($model, 'image')->widget(FileInput::className());
            }
            ?>
            <?= $form->field($model, 'isPublished')->checkbox() ?>
        </div>
    </div>
    <?php
        if ($model->hasAttribute('previewText')) {
            echo $form->field($model, 'previewText')->widget(CKEditor::className());
        }
    ?>
    <?= $form->field($model, 'text')->widget(CKEditor::className()) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

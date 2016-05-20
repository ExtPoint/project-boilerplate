<?php

namespace app\views;

use Yii;
use yii\web\View;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\dictionary\models\Dictionary;

/* @var View $this */
/* @var Dictionary $dictionaryModel */

?>

<h1><?= Html::encode($this->title) ?></h1>

<?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?>

    <?= $form->field($dictionaryModel, 'type')->textInput(['maxlength' => true]) ?>
    <?= $form->field($dictionaryModel, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($dictionaryModel, 'title')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-6">
            <?= Html::submitButton($dictionaryModel->isNewRecord ? 'Добавить' : 'Сохранить', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>

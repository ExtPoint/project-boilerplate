<?php

namespace app\views;

use app\content\enums\ContentType;
use app\content\forms\ContentSearch;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\widgets\ListView;

/* @var $this \yii\web\View */
/* @var $searchModel ContentSearch */
/* @var $contentDataProvider \yii\data\ActiveDataProvider */

?>
<div class="content-index">


    <div class="row">
        <div class="col-md-8">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>

        <div class="col-md-4">
            <?php $form = ActiveForm::begin([
                'action' => ['/content/content/index', 'type' => ContentType::NEWS],
                'method' => 'get',
            ]); ?>
            <?= $form->field($searchModel, 'createTime', [
                'inputTemplate' =>
                    '<div class="input-group col-md-12">
						{input}<span class="input-group-btn"><button class="btn btn-success">Найти</button></span>
					</div>'
            ])
                ->label('Поиск по дате')
                ->widget(DatePicker::classname(), [
                    'dateFormat' => 'php:Y-m-d',
                    'options' => [
                        'class' => 'form-control'
                    ]
                ]) ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>

    <?= ListView::widget([
        'dataProvider' => $contentDataProvider,
        'layout' => "{items}\n{pager}",
        'itemView' => '_item',
        'separator' => '<hr />',
    ]); ?>

</div>

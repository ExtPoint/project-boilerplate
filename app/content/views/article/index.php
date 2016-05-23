<?php

namespace app\views;

use app\content\enums\ContentType;
use app\content\forms\ArticleSearch;
use app\content\forms\ContentSearch;
use app\core\widgets\AppActiveForm;
use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\widgets\ListView;

/* @var $this \yii\web\View */
/* @var $searchModel ArticleSearch */
/* @var $contentDataProvider \yii\data\ActiveDataProvider */

?>


<div class="row">
    <div class="col-md-8">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>

    <div class="col-md-4">
        <?php $form = AppActiveForm::begin([
            'action' => ['/content/article/index', 'type' => $searchModel->type],
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
        <?php AppActiveForm::end(); ?>
    </div>
</div>

<?= ListView::widget([
    'dataProvider' => $contentDataProvider,
    'layout' => "{items}\n{pager}",
    'itemView' => '_item',
    'separator' => '<hr />',
]); ?>


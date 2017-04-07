<?php

namespace app\views;

use yii\web\View;
use app\core\widgets\MenuLink;
use app\core\widgets\AppActiveForm;
use app\core\models\User;

/* @var $this View */
/* @var $model User */

?>

<div class="indent">
    <?= MenuLink::widget([
        'icon' => 'glyphicon glyphicon-arrow-left',
        'label' => 'К списку',
        'url' => ['index'],
        'options' => [
            'class' => 'btn btn-default',
        ]
    ]) ?>
    <?= MenuLink::widget([
        'label' => 'Просмотр',
        'url' => ['view', 'id' => $model->id],
        'visible' => !$model->isNewRecord,
        'options' => [
            'class' => 'btn btn-default',
        ]
    ]) ?>

    <div class="pull-right">
        <?= MenuLink::widget([
            'icon' => 'glyphicon glyphicon-remove',
            'label' => 'Удалить',
            'url' => ['delete', 'id' => $model->id],
            'visible' => !$model->isNewRecord,
            'options' => [
                'class' => 'btn btn-danger',
                'data-confirm' => 'Удалить запись?',
                'data-method' => 'post',
            ]
        ]) ?>
    </div>
</div>

<?php $form = AppActiveForm::begin() ?>

<?= $form->fields($model) ?>
<?= $form->controls($model) ?>

<?php AppActiveForm::end() ?>

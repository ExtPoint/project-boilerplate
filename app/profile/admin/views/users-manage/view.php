<?php

namespace app\views;

use yii\web\View;
    use app\core\widgets\MenuLink;
use app\core\widgets\AppDetailView;
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
        'url' => ['update', 'id' => $model->id],
        'options' => [
            'class' => 'btn btn-warning',
        ]
    ]) ?>

    <div class="pull-right">
        <?= MenuLink::widget([
            'icon' => 'glyphicon glyphicon-remove',
            'label' => 'Удалить',
            'url' => ['delete', 'id' => $model->id],
            'options' => [
                'class' => 'btn btn-danger',
                'data-confirm' => 'Удалить запись?',
                'data-method' => 'post',
            ]
        ]) ?>
    </div>
</div>

<?= AppDetailView::widget([
    'model' => $model,
]) ?>

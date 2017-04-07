<?php

namespace app\views;

use app\profile\admin\forms\UserSearch;
use app\core\widgets\AppGridView;
use yii\data\ActiveDataProvider;
use app\core\widgets\MenuLink;
use yii\web\View;

/* @var $this View */
/* @var $dataProvider ActiveDataProvider */
/* @var $searchModel UserSearch */

?>

    <div class="indent">
        <?= MenuLink::widget([
            'icon' => 'glyphicon glyphicon-plus',
            'label' => 'Добавить',
            'url' => ['create'],
            'options' => [
                'class' => 'btn btn-success',
            ]
        ]) ?>
    </div>

<?= AppGridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'actions' => ['view', 'update', 'delete'],
]); ?>

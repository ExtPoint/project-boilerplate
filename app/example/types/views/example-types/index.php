<?php

namespace app\views;

use app\example\types\forms\GameSearch;
use app\core\widgets\AppGridView;
use yii\data\ActiveDataProvider;
use app\core\widgets\CrudControls;
use yii\web\View;

/* @var $this View */
/* @var $dataProvider ActiveDataProvider */
/* @var $searchModel GameSearch */

?>

<div class="indent">
    <?= CrudControls::widget() ?>
</div>

<?= AppGridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'actions' => [
        'view',
        'update',
        'delete'
    ],
]); ?>

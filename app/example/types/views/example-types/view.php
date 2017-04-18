<?php

namespace app\views;

use yii\web\View;
use app\core\widgets\CrudControls;
use app\core\widgets\AppDetailView;
use app\example\types\models\Game;

/* @var $this View */
/* @var $model Game */

?>

<div class="indent">
    <?= CrudControls::widget() ?>
</div>

<?= AppDetailView::widget([
    'model' => $model,
]) ?>

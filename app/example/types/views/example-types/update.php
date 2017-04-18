<?php

namespace app\views;

use yii\web\View;
use app\core\widgets\CrudControls;
use app\core\widgets\AppActiveForm;
use app\example\types\models\Game;

/* @var $this View */
/* @var $model Game */

?>

<div class="indent">
    <?= CrudControls::widget() ?>
</div>

<?php $form = AppActiveForm::begin() ?>

<?= $form->fields($model) ?>
<?= $form->controls($model) ?>

<?php AppActiveForm::end() ?>

<?php

namespace app\views;

use app\gii\admin\widgets\CrudFrom\CrudFrom;

/* @var $this \yii\web\View */
/* @var $initialValues array */

?>

<?= CrudFrom::widget([
    'initialValues' => $initialValues
]) ?>

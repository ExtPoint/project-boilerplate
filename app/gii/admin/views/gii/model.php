<?php

namespace app\views;

use app\gii\admin\widgets\ModelEditor\ModelEditor;

/* @var $this \yii\web\View */
/* @var $initialValues array */

?>

<?= ModelEditor::widget([
    'initialValues' => $initialValues
]) ?>

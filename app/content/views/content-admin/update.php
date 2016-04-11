<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\content\models\Content */

?>
<div>

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php

namespace app\views;

use app\dictionary\models\Dictionary;
use Yii;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;

/* @var View $this */
/* @var Dictionary $dictionary */

?>

<h1><?= Html::encode($this->title) ?></h1>

<?= DetailView::widget([
    'model' => $dictionary,
    'attributes' => [
        'type',
        'name',
        'title',
        'createTime',
        'updateTime',
    ],
]) ?>

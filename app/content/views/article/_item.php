<?php

namespace app\views;

use app\content\models\Article;
use yii\bootstrap\Html;
use yii\helpers\Url;

/* @var $model Article */

?>

<div class="media">
    <?php if ($model->imageUrl) { ?>
        <div class="media-left">
            <a href="<?= Url::to(['/content/content/view', 'type' => $model->type, 'uid' => $model->uid]) ?>">
                <img class="media-object" src="<?= $model->imageUrl ?> " alt="<?= $model->title ?>" />
            </a>
        </div>
    <?php } ?>
    <div class="media-body">
        <h4 class="media-heading">
            <small><?= \Yii::$app->formatter->asDate($model->createTime) ?></small>
            <?= Html::a($model->title, ['/content/content/view', 'type' => $model->type, 'uid' => $model->uid]) ?>
        </h4>
        <?= $model->previewText ?>
    </div>
</div>
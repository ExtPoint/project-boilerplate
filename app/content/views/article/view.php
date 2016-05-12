<?php

namespace app\views;

use app\content\models\Article;
use app\content\models\Content;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $contentModel Article */

?>
<div class="text-center">
    <img src="<?= $contentModel->imageBigUrl ?> " alt="<?= $contentModel->title ?>" />
    <br />
    <br />
    <h1 class="media-heading">
        <small><?= \Yii::$app->formatter->asDate($contentModel->createTime) ?></small>
        <?= Html::a($contentModel->title, ['/content/content/view', 'type' => $contentModel->type, 'uid' => $contentModel->uid]) ?>
    </h1>
</div>
<?= $contentModel->text ?>
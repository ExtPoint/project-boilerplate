<?php

namespace app\views;

use app\content\enums\ContentType;
use app\content\models\Content;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;

/* @var $this \yii\web\View */
/* @var $contentModel Content */

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
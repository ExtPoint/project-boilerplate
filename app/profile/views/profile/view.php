<?php

namespace app\views;

use app\profile\enums\UserRole;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this \yii\web\View */
/* @var $userModel \app\core\models\User */
?>
<h1>
    <?= Html::encode($userModel->name) ?>
    <?php if (\Yii::$app->user->uid === $userModel->uid || \Yii::$app->user->can(UserRole::ADMIN)) { ?>
        <small><?= Html::a('Редактировать профиль', ['/profile/profile-edit/index', 'userUid' => $userModel->uid]) ?></small>
    <?php } ?>
</h1>

<div class="media">
    <?php if ($userModel->photoUrl) { ?>
    <div class="media-left col-md-2">
        <?= Html::img($userModel->photoUrl, ['class' => 'img-thumbnail']) ?>
    </div>
    <?php } ?>
    <div class="media-body">
        <?= DetailView::widget([
            'model' => $userModel,
            'attributes' => [
                'info.firstName',
                'info.lastName',
                [
                    'attribute' => 'email',
                    'visible' => $userModel->canViewAttribute(\Yii::$app->user->model, 'email'),
                ],
                [
                    'attribute' => 'info.phone',
                    'visible' => $userModel->info->canViewAttribute(\Yii::$app->user->model, 'phone'),
                ],
                'info.birthday',
                'createTime',
            ],
        ]) ?>
    </div>
</div>

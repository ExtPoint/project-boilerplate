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
    <?php if (\Yii::$app->user->id === $userModel->id || \Yii::$app->user->can(UserRole::ADMIN)) { ?>
        <small><?= Html::a('Редактировать профиль', ['/profile/profile-edit/index', 'userId' => $userModel->id]) ?></small>
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
                'firstName',
                'lastName',
                [
                    'attribute' => 'email',
                    'visible' => $userModel->canViewAttribute(\Yii::$app->user->model, 'email'),
                ],
                [
                    'attribute' => 'phone',
                    'visible' => $userModel->canViewAttribute(\Yii::$app->user->model, 'phone'),
                ],
                'birthday',
                'createTime',
            ],
        ]) ?>
    </div>
</div>

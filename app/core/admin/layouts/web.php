<?php

namespace app\views;

use Yii;
use app\core\admin\widgets\Alert;
use app\core\admin\widgets\SidebarNav;
use app\core\admin\widgets\TopNav;
use app\core\assets\FrontendAssetBundle;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Breadcrumbs;

/* @var $this \yii\web\View */
/* @var $content string */

FrontendAssetBundle::register($this);

$this->registerJsFile('@static/assets/bundle-index.js', ['position' => View::POS_BEGIN]);
$this->registerJsFile('@static/assets/bundle-style-admin.js', ['position' => View::POS_BEGIN]);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode(Yii::$app->megaMenu->getFullTitle()) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<nav class="navbar navbar-inverse navbar-static-top">
    <div class="navbar-header pull-left">
        <button type="button" class="navbar-toggle navbar-toggle-left" data-toggle="collapse" data-target=".sidebar">
            <span class="sr-only"><?= Yii::t('app', 'Toggle sidebar') ?></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand hidden-xs" href="<?= Url::to(['/admin/default/index']) ?>"><?= Yii::$app->name ?></a>
    </div>
    <?= TopNav::widget([
        'options' => ['class' => 'nav top-nav'],
        'items' => [
            [
                'label' => 'Перейти на сайт',
                'icon' => 'fa fa-fw fa-globe',
                'url' => Yii::$app->homeUrl,
            ],
            [
                'label' => Yii::$app->name,
                'customIcon' => Yii::$app->user->model->photoUrl ?
                    Html::img(Yii::$app->user->model->photoUrl, ['class' => 'img-avatar avatar-small'])
                    : null,
                'url' => '#',
                'items' => [
                    [
                        'label' => 'Выйти',
                        'url' => ['/auth/auth/logout'],
                        'linkOptions' => ['data-method' => 'post'],
                    ],
                ],
            ]
        ],
    ]) ?>
</nav>

<div class="wrapper clearfix">
    <div class="sidebar-back"></div>
    <div class="sidebar collapse">
        <?= SidebarNav::widget([
            'items' => Yii::$app->megaMenu->getMenu('admin', 1),
        ]); ?>
    </div>
    <div class="main">
        <div class="main-inner">

            <?= Breadcrumbs::widget([
                'links' => \Yii::$app->megaMenu->getBreadcrumbs(),
                'homeLink' => false,
            ]) ?>
            <?php if (Yii::$app->megaMenu->getTitle()) { ?>
                <h1 class="page-header"><?= Yii::$app->megaMenu->getTitle() ?></h1>
            <?php } ?>

            <?= Alert::widget() ?>

            <?= $content ?>

        </div>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

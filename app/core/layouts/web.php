<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

/* @var $this \yii\web\View */
/* @var $content string */

$this->registerJsFile('@web/assets/main.js');
$this->registerCssFile('@web/assets/main.css');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= $this->title ? Html::encode($this->title) . ' — ' : '' ?>Boilerplate Yii 2 k4nuj8</title>
    <?php $this->head() ?>
</head>
<body>

<?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => 'Boilerplate Yii 2 k4nuj8',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-static-top',
                ],
            ]);
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => [
                    ['label' => 'Главная', 'url' => ['/site/site/index']],
                    ['label' => 'Comet', 'url' => ['/comet/comet/index']],
                    ['label' => 'About', 'url' => ['/site/site/about']],
                    Yii::$app->user->isGuest ?
                        ['label' => 'Вход', 'url' => ['/auth/auth/login']] :
                        ['label' => 'Выход (' . Yii::$app->user->model->name . ')',
                            'url' => ['/auth/auth/logout'],
                            'linkOptions' => ['data-method' => 'post']],
                ],
            ]);
            NavBar::end();
        ?>

        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?php
                foreach (Yii::$app->session->getAllFlashes() as $key => $messages) {
                    $messages = is_array($messages) ? $messages : [$messages];
                    foreach ($messages as $message) {
                        echo '<div class="alert alert-' . $key . '">' . $message . '</div>';
                    }
                }
            ?>
            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; Boilerplate Yii 2 k4nuj8 <?= date('Y') ?></p>
            <p class="pull-right"></p>
        </div>
    </footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

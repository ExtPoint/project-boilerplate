<?
namespace app\views;

use app\comet\assets\NeatCometAssetBundle;
use yii\web\View;

/** @var View $this */

NeatCometAssetBundle::register($this);
?>


<?php $this->registerJs("
    var profile = Jii.app.neat.openProfile('all');

    profile.getCollection('user').on('add', function(model) {
        console.log(model)
    });
", View::POS_READY);

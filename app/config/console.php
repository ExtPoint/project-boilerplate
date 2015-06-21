<?php

Yii::setAlias('@tests', dirname(__DIR__) . '/tests');

return \yii\helpers\ArrayHelper::merge(
    require 'main.php',
    [
        'controllerNamespace' => 'app\commands',
    ]
);

<?php

use extpoint\yii2\components\ModuleLoader;

Yii::setAlias('@tests', dirname(dirname(__DIR__)) . '/tests');
Yii::setAlias('@webroot', dirname(dirname(__DIR__)) . '/public');

return \yii\helpers\ArrayHelper::merge(
    require 'main.php',
    [
        'controllerNamespace' => 'app\commands',
        'controllerMap' => [
            'migrate' => [
                'class' => '\yii\console\controllers\MigrateController',
                'migrationPath' => null,
                'migrationNamespaces' => ModuleLoader::getMigrationNamespaces(dirname(__DIR__)),
            ],
        ],
    ]
);

<?php

require_once __DIR__ . '/../core/components/ModuleLoader.php';

return [
    'id' => 'boilerplate-yii2-k4nuj8',
    'basePath' => dirname(__DIR__),
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'runtimePath' => dirname(dirname(__DIR__)) . '/files/log/runtime',
    'bootstrap' => \app\core\components\ModuleLoader::getBootstrap() + ['log'],
    'language' => 'ru',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'htmlLayout' => '@app/core/layouts/mail',
            'messageConfig' => [
                'from' => 'noreply@example.com'
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=boilerplate-yii2-k4nuj8',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ],
        'assetManager' => [
            'forceCopy' => true,
            'bundles' => [
                // Disables Yii jQuery
                'yii\web\JqueryAsset' => [
                    'sourcePath' => null,
                    'js' => [],
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'sourcePath' => null,
                    'css' => [],
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'sourcePath' => null,
                    'js' => [],
                    'css' => [],
                ],
            ],
        ],
        'urlManager'=> [
            'showScriptName' => false,
            'enablePrettyUrl' => true,
            //'enableStrictParsing' => true,
            'suffix' => '/',
        ],
    ],
    'modules' => \app\core\components\ModuleLoader::getConfig(),
    'params' => [
        'adminEmail' => '',
    ],
];

<?php

return [
    'id' => 'boilerplate-yii2-k4nuj8',
    'basePath' => dirname(__DIR__),
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'runtimePath' => dirname(dirname(__DIR__)) . '/files/log/runtime',
    'bootstrap' => ['log'],
    'language' => 'ru',
    'controllerMap' => [
        'migrate' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationPath' => '@app/core/migrations',
        ],
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => true,
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
            'rules' => [
                '' => 'site/site/index',
            ],
        ],
    ],
    'modules' => [
        'core' => 'app\core\CoreModule',
        'site' => 'app\site\SiteModule',
    ],
    'params' => [
        'adminEmail' => '',
    ],
];

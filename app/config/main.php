<?php

return [
    'id' => 'boilerplate-yii2-k4nuj8',
    'basePath' => dirname(__DIR__),
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'runtimePath' => dirname(dirname(__DIR__)) . '/files/log/runtime',
    'bootstrap' => ['log'],
    'language' => 'ru',
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
        ],
        'urlManager'=> [
            'showScriptName' => false,
            'enablePrettyUrl' => true,
            //'enableStrictParsing' => true,
            'suffix' => '/',
            'rules' => [
                '' => 'core/site/index',
            ],
        ],
    ],
    'modules' => [
        'core' => 'app\core\Module',
    ],
    'params' => [
        'adminEmail' => '',
    ],
];

<?php

use extpoint\yii2\components\ModuleLoader;

ModuleLoader::add('gii', 'extpoint\yii2\gii\GiiModule');
ModuleLoader::add('file', 'extpoint\yii2\file\FileModule');

return [
    'id' => 'boilerplate-yii2-k4nuj8',
    'name' => 'Boilerplate Yii 2 k4nuj8',
    'basePath' => dirname(__DIR__),
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'runtimePath' => dirname(dirname(__DIR__)) . '/files/log/runtime',
    'bootstrap' => ModuleLoader::getBootstrap(dirname(__DIR__)) + ['log'],
    'language' => 'ru',
    'timeZone' => ($timeZone = 'UTC'),
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
            'on afterOpen' => function ($event) {
                $event->sender->createCommand("SET time_zone='" . date('P') . "'")->execute();
            },
        ],
        'formatter' => [
            'defaultTimeZone' => $timeZone,
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
        'urlManager' => [
            'showScriptName' => false,
            'enablePrettyUrl' => true,
            'suffix' => '/',
            'normalizer' => [
                'class' => 'yii\web\UrlNormalizer',
                'collapseSlashes' => true,
                'normalizeTrailingSlash' => true,
            ],
        ],
        'megaMenu' => [
            'class' => '\extpoint\megamenu\MegaMenu',
        ],
    ],
    'modules' => ModuleLoader::getConfig(dirname(__DIR__)),
    'params' => [
        'adminEmail' => '',
    ],
];

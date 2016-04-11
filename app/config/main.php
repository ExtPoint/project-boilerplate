<?php

\Yii::$container->set(\dosamigos\ckeditor\CKEditor::className(), [
    'clientOptions' => [
        'toolbarGroups' => [
            ['name' => 'styles'],
            ['name' => 'clipboard', 'groups' => ['clipboard', 'undo']],
            ['name' => 'document', 'groups' => ['mode']],
            ['name' => 'links'],
            ['name' => 'forms'],
            ['name' => 'tools'],
            ['name' => 'tools'],
            '/',
            ['name' => 'basicstyles', 'groups' => ['basicstyles', 'colors','cleanup']],
            ['name' => 'paragraph', 'groups' => [ 'list', 'indent', 'blocks', 'align', 'bidi' ]],
            ['name' => 'insert'],
        ],
        'removeButtons' => 'Form,Checkbox,Radio,TextField,Textarea,Select,Button,HiddenField',
        'extraPlugins' => 'filebrowser',
        'filebrowserUploadUrl' => '/cms/page/upload/'
    ],
    'preset' => 'custom',
]);

return [
    'id' => 'boilerplate-yii2-k4nuj8',
    'name' => 'Boilerplate Yii 2 k4nuj8',
    'basePath' => dirname(__DIR__),
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'runtimePath' => dirname(dirname(__DIR__)) . '/files/log/runtime',
    'bootstrap' => \extpoint\yii2\components\ModuleLoader::getBootstrap(dirname(__DIR__)) + ['log'],
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
        'megaMenu'=> [
            'class' => '\extpoint\yii2\components\MegaMenu',
        ],
    ],
    'modules' => \extpoint\yii2\components\ModuleLoader::getConfig(dirname(__DIR__)),
    'params' => [
        'adminEmail' => '',
    ],
];

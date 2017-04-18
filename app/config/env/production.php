<?php

return [
    'runtimePath' => __DIR__ . '/../../../../files/log/runtime',
    'components' => [
        'assetManager' => [
            'basePath' => __DIR__ . '/../../../../files/assets',
        ],
        'mailer' => [
            'messageConfig' => [
                'from' => 'noreply@boilerplate-yii2-k4nuj8.ru'
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
    'modules' => [
        'file' => [
            'filesRootPath' => __DIR__ . '/../../../../files/uploaded',
            'filesRootUrl' => '/files/uploaded',
        ],
    ],
];
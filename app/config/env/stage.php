<?php

return [
    'runtimePath' => __DIR__ . '/../../../../files/log/runtime',
    'components' => [
        'mailer' => [
            'messageConfig' => [
                'from' => 'noreply@boilerplate-yii2-k4nuj8.stage.extpoint.com'
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
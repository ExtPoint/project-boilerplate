<?php

return \yii\helpers\ArrayHelper::merge(
    require 'main.php',
    [
        'defaultRoute' => 'site/site/index',
        'components' => [
            'request' => [
                'cookieValidationKey' => 'q2%s2~5twSe2OkBJ8H6k6wUI@fe~Ah9|',
            ],
            'user' => [
                'class' => '\app\core\components\ContextUser',
                'identityClass' => 'app\core\models\User',
                'enableAutoLogin' => true,
            ],
            'errorHandler' => [
                'errorAction' => 'site/site/error',
            ],
            'authClientCollection' => [
                'class' => \yii\authclient\Collection::className(),
                'clients' => [
                    'google' => [
                        'class' => 'yii\authclient\clients\Google',
                        //'clientId' => 'google_client_id',
                        //'clientSecret' => 'google_client_secret',
                     ],
                    'facebook' => [
                        'class' => 'yii\authclient\clients\Facebook',
                        //'clientId' => 'facebook_client_id',
                        //'clientSecret' => 'facebook_client_secret',
                    ],
                    'yandex' => [
                        'class' => 'yii\authclient\clients\Yandex',
                        //'clientId' => 'yandex_client_id',
                        //'clientSecret' => 'yandex_client_secret',
                    ],
                    'vkontakte' => [
                        'class' => 'yii\authclient\clients\VKontakte',
                        //'clientId' => 'vkontakte_client_id',
                        //'clientSecret' => 'vkontakte_client_secret',
                    ],
                    'twitter' => [
                        'class' => 'yii\authclient\clients\Twitter',
                        'attributeParams' => [
                            'include_email' => 'true'
                        ],
                        //'consumerKey' => 'twitter_consumer_key',
                        //'consumerSecret' => 'twitter_consumer_secret',
                    ],
                    'live' => [
                        'class' => 'yii\authclient\clients\Live',
                        //'clientId' => 'live_client_id',
                        //'clientSecret' => 'live_client_secret',
                    ],
                    'linkedin' => [
                        'class' => 'yii\authclient\clients\LinkedIn',
                        //'clientId' => 'linkedin_client_id',
                        //'clientSecret' => 'linkedin_client_secret',
                    ],
                    'github' => [
                        'class' => 'yii\authclient\clients\GitHub',
                        //'clientId' => 'github_client_id',
                        //'clientSecret' => 'github_client_secret',
                    ],
                ],
            ]
        ],
    ]
);
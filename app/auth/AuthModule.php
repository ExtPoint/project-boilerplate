<?php

namespace app\auth;

use app\core\base\AppModule;
use extpoint\megamenu\MenuHelper;
use yii\authclient\Collection;

class AuthModule extends AppModule {

    /**
     * @var Collection
     */
    public $authClientCollection;

    public $enableSocial = false;

    public function coreMenu() {
        return [
            [
                'label' => \Yii::t('app', 'Регистрация'),
                'url' => ["/$this->id/auth/registration"],
                'urlRule' => 'registration',
                'roles' => '?',
                'items' => [
                    [
                        'label' => \Yii::t('app', 'Пользовательское соглашение'),
                        'url' => ["/$this->id/auth/agreement"],
                        'urlRule' => 'registration/agreement',
                    ],
                ],
                'order' => 95,
            ],
            [
                'label' => \Yii::t('app', 'Вход'),
                'url' => ["/$this->id/auth/login"],
                'urlRule' => 'login',
                'roles' => '?',
                'items' => [
                    [
                        'label' => \Yii::t('app', 'Восстановление пароля'),
                        'url' => ["/$this->id/recovery/index"],
                        'urlRule' => 'login/recovery',
                        'items' => [
                            [
                                'url' => ["/$this->id/recovery/captcha"],
                                'urlRule' => 'login/recovery/captcha',
                            ],
                            [
                                'label' => \Yii::t('app', 'Проверочный код'),
                                'url' => ["/$this->id/recovery/code"],
                                'urlRule' => 'login/recovery/<code>',
                            ],
                        ],
                    ],
                ],
                'order' => 100,
            ],
            [
                'label' => \Yii::t('app', 'Выход ({name})', ['name' => MenuHelper::paramUser('name')]),
                'url' => ["/$this->id/auth/logout"],
                'urlRule' => 'logout',
                'linkOptions' => ['data-method' => 'post'],
                'roles' => '@',
                'order' => 100,
            ],
        ];
    }

    public function coreComponents()
    {
        return [
            'authClientCollection' => [
                'class' => Collection::className(),
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
        ];
    }

}

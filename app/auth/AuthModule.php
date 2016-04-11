<?php

namespace app\auth;

use extpoint\yii2\base\AppModule;

class AuthModule extends AppModule {

    protected function coreUrlRules() {
        return [
            'login/recovery/captcha' => "$this->id/recovery/captcha",
        ];
    }

    public function coreMenus() {
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
                                'label' => \Yii::t('app', 'Проверочный код'),
                                'url' => ["/$this->id/recovery/code"],
                                'urlRule' => 'login/recovery/<code>',
                            ],
                        ],
                    ],
                ],
            ],
            [
                'label' => \Yii::t('app', 'Выход ({name})', ['name' => \Yii::$app->has('user') ? \Yii::$app->user->name : '']),
                'url' => ["/$this->id/auth/logout"],
                'urlRule' => 'logout',
                'linkOptions' => ['data-method' => 'post'],
                'roles' => '@',
            ],
        ];
    }

}

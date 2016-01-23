<?php

namespace app\auth;

use app\core\base\AppModule;

class AuthModule extends AppModule {

    protected function coreUrlRules() {
        return [
            'login/recovery/captcha' => "$this->id/recovery/captcha",
            'login/recovery/<code>' => "$this->id/recovery/code",
            'login/recovery' => "$this->id/recovery/index",
            'registration/agreement' => "$this->id/auth/agreement",
            '<action:login|registration|logout>' => "$this->id/auth/<action>",
        ];
    }

    public function coreMenus() {
        return [
            [
                'label' => \Yii::t('app', 'Регистрация'),
                'url' => ["/$this->id/auth/registration"],
                'roles' => '?',
                'items' => [
                    [
                        'label' => \Yii::t('app', 'Пользовательское соглашение'),
                        'url' => ["/$this->id/auth/agreement"],
                    ],
                ],
            ],
            [
                'label' => \Yii::t('app', 'Вход'),
                'url' => ["/$this->id/auth/login"],
                'roles' => '?',
                'items' => [
                    [
                        'label' => \Yii::t('app', 'Восстановление пароля'),
                        'url' => ["/$this->id/recovery/index"],
                        'items' => [
                            [
                                'label' => \Yii::t('app', 'Проверочный код'),
                                'url' => ["/$this->id/recovery/code"],
                            ],
                        ],
                    ],
                ],
            ],
            [
                'label' => \Yii::t('app', 'Выход ({name})', ['name' => \Yii::$app->user->name]),
                'url' => ["/$this->id/auth/logout"],
                'linkOptions' => ['data-method' => 'post'],
                'roles' => '@',
            ],
        ];
    }

}

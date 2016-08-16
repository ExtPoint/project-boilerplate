<?php

namespace app\auth;

use app\core\base\AppModule;
use extpoint\megamenu\MenuHelper;

class AuthModule extends AppModule {

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

}

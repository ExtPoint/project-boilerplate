<?php

namespace app\profile;

use app\core\base\AppModule;
use app\profile\enums\UserRole;
use extpoint\megamenu\MenuHelper;
use yii\web\Request;

class ProfileModule extends AppModule {

    public function coreMenu() {
        return [
            'admin' => [
                'label' => 'Администрирование',
                'roles' => UserRole::ADMIN,
                'items' => [
                    [
                        'label' => 'Пользователи',
                        'url' => ["/$this->id/$this->id-admin/index"],
                        'urlRule' => 'admin/profiles',
                    ],
                ]
            ],
            [
                'label' => 'Мой профиль',
                'url' => ["/$this->id/$this->id/view", 'userId' => MenuHelper::paramUser('id')],
                'urlRule' => 'profile',
                'roles' => '@',
                'items' => [
                    [
                        'label' => 'Редактирование профиля',
                        'url' => ["/$this->id/$this->id-edit/index", 'userId' => MenuHelper::paramUser('id')],
                        'urlRule' => 'profile/edit',
                        'items' => [
                            [
                                'label' => 'Основные',
                                'url' => ["/$this->id/$this->id-edit/index", 'userId' => MenuHelper::paramUser('id')],
                                'urlRule' => 'profile/edit',
                            ],
                            [
                                'label' => 'Пароль',
                                'url' => ["/$this->id/$this->id-edit/password", 'userId' => MenuHelper::paramUser('id')],
                                'urlRule' => 'profile/edit/password',
                            ],
                        ],
                    ],
                ],
            ],
            [
                'label' => 'Профиль',
                'url' => ["/$this->id/$this->id/view", 'userId' => MenuHelper::paramGet('userId')],
                'urlRule' => 'profile/<userId>',
                'visible' => false,
                'roles' => '@',
                'items' => [
                    [
                        'label' => 'Редактирование профиля',
                        'url' => ["/$this->id/$this->id-edit/index", 'userId' => MenuHelper::paramGet('userId')],
                        'urlRule' => 'profile/<userId>/edit',
                        'items' => [
                            [
                                'label' => 'Основные',
                                'url' => ["/$this->id/$this->id-edit/index", 'userId' => MenuHelper::paramGet('userId')],
                                'urlRule' => 'profile/<userId>/edit',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

}
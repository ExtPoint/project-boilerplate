<?php

namespace app\profile;

use app\core\base\AppModule;
use app\profile\controllers\ProfileController;
use app\profile\controllers\ProfileEditController;

class ProfileModule extends AppModule {

    public function coreMenu() {
        return [
            [
                'label' => 'Мой профиль',
                'url' => ["/profile/profile/view"],
                'urlRule' => 'profile',
                'roles' => '@',
                'items' => [
                    [
                        'label' => 'Редактирование профиля',
                        'url' => ["/profile/profile-edit/index"],
                        'urlRule' => 'profile/edit',
                        'items' => [
                            [
                                'label' => 'Основные',
                                'url' => ["/profile/profile-edit/index"],
                                'urlRule' => 'profile/edit',
                            ],
                            [
                                'label' => 'Пароль',
                                'url' => ["/profile/profile-edit/password"],
                                'urlRule' => 'profile/edit/password',
                            ],
                        ],
                    ],
                ],
            ],
            [
                'label' => 'Профиль',
                'url' => ["/profile/profile/view", ':userId'],
                'urlRule' => 'profile/<userId>',
                'visible' => false,
                'roles' => '@',
                'items' => [
                    [
                        'label' => 'Редактирование профиля',
                        'url' => ["/profile/profile-edit/index", ':userId'],
                        'urlRule' => 'profile/<userId>/edit',
                        'items' => [
                            [
                                'label' => 'Основные',
                                'url' => ["/profile/profile-edit/index", ':userId'],
                                'urlRule' => 'profile/<userId>/edit',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }
}

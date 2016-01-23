<?php

namespace app\profile;

use app\core\base\AppModule;

class ProfileModule extends AppModule {

    protected function coreUrlRules() {
        return [
            'profile' => "$this->id/profile/index",
            'profile/edit' => "$this->id/profile-edit/index",
            'profile/edit/<action>' => "$this->id/profile-edit/<action>",
        ];
    }

    public function coreMenus() {
        return [
            [
                'label' => 'Профиль',
                'url' => ["/$this->id/profile/index"],
                'roles' => '@',
                'items' => [
                    [
                        'label' => 'Редактирование профиля',
                        'url' => ["/$this->id/profile-edit/index"],
                        'items' => [
                            [
                                'label' => 'Основные',
                                'url' => ["/$this->id/profile-edit/index"],
                            ],
                            [
                                'label' => 'Пароль',
                                'url' => ["/$this->id/profile-edit/password"],
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

}
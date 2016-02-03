<?php

namespace app\profile;

use app\core\base\AppModule;
use app\profile\enums\UserRole;

class ProfileModule extends AppModule {

    protected function coreUrlRules() {
        return [
            [
                'pattern' => 'profile/<userUid>/edit',
                'route' => "$this->id/profile-edit/index",
                'defaults' => [
                    'userUid' => \Yii::$app->user->uid,
                ],
            ],
            [
                'pattern' => 'profile/<userUid>/edit/<action>',
                'route' => "$this->id/profile-edit/<action>",
                'defaults' => [
                    'userUid' => \Yii::$app->user->uid,
                ],
            ],
            [
                'pattern' => 'profile/<userUid>',
                'route' => "$this->id/profile/view",
                'defaults' => [
                    'userUid' => \Yii::$app->user->uid,
                ],
            ],
        ];
    }

    public function coreMenus() {
        $userUid = \Yii::$app->request->get('userUid') ?: \Yii::$app->user->uid;
        return [
            [
                'label' => 'Пользователи',
                'url' => ["/$this->id/profile-admin/index"],
                'roles' => UserRole::ADMIN,
            ],
            [
                'label' => 'Профиль',
                'url' => ["/$this->id/profile/view", 'userUid' => $userUid],
                'roles' => '@',
                'items' => [
                    [
                        'label' => 'Редактирование профиля',
                        'url' => ["/$this->id/profile-edit/index", 'userUid' => $userUid],
                        'items' => [
                            [
                                'label' => 'Основные',
                                'url' => ["/$this->id/profile-edit/index", 'userUid' => $userUid],
                            ],
                            [
                                'label' => 'Пароль',
                                'url' => ["/$this->id/profile-edit/password", 'userUid' => $userUid],
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

}
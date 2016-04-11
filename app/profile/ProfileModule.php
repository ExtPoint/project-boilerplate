<?php

namespace app\profile;

use extpoint\yii2\base\AppModule;
use app\profile\enums\UserRole;

class ProfileModule extends AppModule {

    public function coreMenus() {
        return [
            'admin' => [
                'label' => 'Администрирование',
                'roles' => UserRole::ADMIN,
                'urlRule' => 'admin/profiles',
                'items' => [
                    [
                        'label' => 'Пользователи',
                        'url' => ["/$this->id/$this->id-admin/index"],
                    ],
                ]
            ],
            [
                'label' => 'Мой профиль',
                'url' => ["/$this->id/$this->id/view", 'userUid' => \Yii::$app->user->uid],
                'urlRule' => 'profile',
                'roles' => '@',
                'items' => [
                    [
                        'label' => 'Редактирование профиля',
                        'url' => ["/$this->id/$this->id-edit/index", 'userUid' => \Yii::$app->user->uid],
                        'urlRule' => 'profile/edit',
                        'items' => [
                            [
                                'label' => 'Основные',
                                'url' => ["/$this->id/$this->id-edit/index", 'userUid' => \Yii::$app->user->uid],
                                'urlRule' => 'profile/edit',
                            ],
                            [
                                'label' => 'Пароль',
                                'url' => ["/$this->id/$this->id-edit/password", 'userUid' => \Yii::$app->user->uid],
                                'urlRule' => 'profile/edit/password',
                            ],
                        ],
                    ],
                ],
            ],
            [
                'label' => 'Профиль',
                'url' => ["/$this->id/$this->id/view", 'userUid' => \Yii::$app->request->get('userUid')],
                'urlRule' => 'profile/<userUid>',
                'visible' => false,
                'roles' => '@',
                'items' => [
                    [
                        'label' => 'Редактирование профиля',
                        'url' => ["/$this->id/$this->id-edit/index", 'userUid' => \Yii::$app->request->get('userUid')],
                        'urlRule' => 'profile/<userUid>/edit',
                        'items' => [
                            [
                                'label' => 'Основные',
                                'url' => ["/$this->id/$this->id-edit/index", 'userUid' => \Yii::$app->request->get('userUid')],
                                'urlRule' => 'profile/<userUid>/edit',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

}
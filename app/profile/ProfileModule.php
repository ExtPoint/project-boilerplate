<?php

namespace app\profile;

use app\core\base\AppModule;
use app\profile\enums\UserRole;
use yii\web\Request;

class ProfileModule extends AppModule {

    public function coreMenus() {
        $contextUserUid = \Yii::$app->has('user') ? \Yii::$app->user->uid : null;
        $userUid = \Yii::$app->request instanceof Request ? \Yii::$app->request->get('userUid') : null;

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
                'url' => ["/$this->id/$this->id/view", 'userUid' => $contextUserUid],
                'urlRule' => 'profile',
                'roles' => '@',
                'items' => [
                    [
                        'label' => 'Редактирование профиля',
                        'url' => ["/$this->id/$this->id-edit/index", 'userUid' => $contextUserUid],
                        'urlRule' => 'profile/edit',
                        'items' => [
                            [
                                'label' => 'Основные',
                                'url' => ["/$this->id/$this->id-edit/index", 'userUid' => $contextUserUid],
                                'urlRule' => 'profile/edit',
                            ],
                            [
                                'label' => 'Пароль',
                                'url' => ["/$this->id/$this->id-edit/password", 'userUid' => $contextUserUid],
                                'urlRule' => 'profile/edit/password',
                            ],
                        ],
                    ],
                ],
            ],
            [
                'label' => 'Профиль',
                'url' => ["/$this->id/$this->id/view", 'userUid' => $userUid],
                'urlRule' => 'profile/<userUid>',
                'visible' => false,
                'roles' => '@',
                'items' => [
                    [
                        'label' => 'Редактирование профиля',
                        'url' => ["/$this->id/$this->id-edit/index", 'userUid' => $userUid],
                        'urlRule' => 'profile/<userUid>/edit',
                        'items' => [
                            [
                                'label' => 'Основные',
                                'url' => ["/$this->id/$this->id-edit/index", 'userUid' => $userUid],
                                'urlRule' => 'profile/<userUid>/edit',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

}
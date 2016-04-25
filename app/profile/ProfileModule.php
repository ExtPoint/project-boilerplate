<?php

namespace app\profile;

use app\core\base\AppModule;
use app\profile\enums\UserRole;

class ProfileModule extends AppModule {

    public function coreMenus() {
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
                'url' => ["/$this->id/$this->id/view", 'userUid' => \Yii::$app->has('user') ? \Yii::$app->user->uid : null],
                'urlRule' => 'profile',
                'roles' => '@',
                'items' => [
                    [
                        'label' => 'Редактирование профиля',
                        'url' => ["/$this->id/$this->id-edit/index", 'userUid' => \Yii::$app->has('user') ? \Yii::$app->user->uid : null],
                        'urlRule' => 'profile/edit',
                        'items' => [
                            [
                                'label' => 'Основные',
                                'url' => ["/$this->id/$this->id-edit/index", 'userUid' => \Yii::$app->has('user') ? \Yii::$app->user->uid : null],
                                'urlRule' => 'profile/edit',
                            ],
                            [
                                'label' => 'Пароль',
                                'url' => ["/$this->id/$this->id-edit/password", 'userUid' => \Yii::$app->has('user') ? \Yii::$app->user->uid : null],
                                'urlRule' => 'profile/edit/password',
                            ],
                        ],
                    ],
                ],
            ],
            [
                'label' => 'Профиль',
                'url' => ["/$this->id/$this->id/view", 'userUid' => \Yii::$app->request instanceof Request ? \Yii::$app->request->get('userUid') : null],
                'urlRule' => 'profile/<userUid>',
                'visible' => false,
                'roles' => '@',
                'items' => [
                    [
                        'label' => 'Редактирование профиля',
                        'url' => ["/$this->id/$this->id-edit/index", 'userUid' => \Yii::$app->request instanceof Request ? \Yii::$app->request->get('userUid') : null],
                        'urlRule' => 'profile/<userUid>/edit',
                        'items' => [
                            [
                                'label' => 'Основные',
                                'url' => ["/$this->id/$this->id-edit/index", 'userUid' => \Yii::$app->request instanceof Request ? \Yii::$app->request->get('userUid') : null],
                                'urlRule' => 'profile/<userUid>/edit',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

}
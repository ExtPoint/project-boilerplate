<?php

namespace app\content;

use app\content\enums\ContentType;
use app\profile\enums\UserRole;
use app\core\base\AppModule;
use yii\web\Request;

class ContentModule extends AppModule {

    public function coreMenus() {
        return [
            'admin' => [
                'label' => 'Администрирование',
                'roles' => UserRole::ADMIN,
                'items' => [
                    [
                        'label' => 'Новости',
                        'url' => ["/$this->id/$this->id-admin/index", 'type' => ContentType::NEWS],
                        'items' => [
                            [
                                'label' => 'Новости',
                                'url' => ["/$this->id/$this->id-admin/index", 'type' => ContentType::NEWS],
                                'urlRule' => 'admin/news'
                            ],
                            [
                                'label' => 'Добавление',
                                'url' => ["/$this->id/$this->id-admin/create", 'type' => ContentType::NEWS],
                                'urlRule' => 'admin/news/add',
                            ],
                            [
                                'label' => 'Редактирование',
                                'url' => ["/$this->id/$this->id-admin/update", 'type' => ContentType::NEWS, 'uid' => \Yii::$app->request instanceof Request ? \Yii::$app->request->get('uid') : null],
                                'urlRule' => 'admin/news/update/<uid>',
                            ],
                        ],
                    ],
                    [
                        'label' => 'Страницы',
                        'url' => ["/$this->id/$this->id-admin/index", 'type' => ContentType::PAGE],
                        'items' => [
                            [
                                'label' => 'Страницы',
                                'url' => ["/$this->id/$this->id-admin/index", 'type' => ContentType::PAGE],
                                'urlRule' => 'admin/pages'
                            ],
                            [
                                'label' => 'Добавление',
                                'url' => ["/$this->id/$this->id-admin/create", 'type' => ContentType::PAGE],
                                'urlRule' => 'admin/pages/add',
                            ],
                            [
                                'label' => 'Редактирование',
                                'url' => ["/$this->id/$this->id-admin/update", 'type' => ContentType::PAGE, 'uid' => \Yii::$app->request instanceof Request ? \Yii::$app->request->get('uid') : null],
                                'urlRule' => 'admin/pages/update/<uid>',
                            ],
                        ],
                    ],
                    [
                        'label' => 'Тексты',
                        'url' => ["/$this->id/$this->id-admin/index", 'type' => ContentType::TEXT],
                        'items' => [
                            [
                                'label' => 'Страницы',
                                'url' => ["/$this->id/$this->id-admin/index", 'type' => ContentType::TEXT],
                                'urlRule' => 'admin/texts'
                            ],
                            [
                                'label' => 'Добавление',
                                'url' => ["/$this->id/$this->id-admin/create", 'type' => ContentType::TEXT],
                                'urlRule' => 'admin/texts/add',
                            ],
                            [
                                'label' => 'Редактирование',
                                'url' => ["/$this->id/$this->id-admin/update", 'type' => ContentType::TEXT, 'uid' => \Yii::$app->request instanceof Request ? \Yii::$app->request->get('uid') : null],
                                'urlRule' => 'admin/texts/update/<uid>',
                            ],
                        ],
                    ],
                ],
            ],
            [
                'label' => 'Новости',
                'url' => ["/$this->id/$this->id/index", 'type' => ContentType::NEWS],
                'urlRule' => 'news',
                'items' => [
                    [
                        'label' => 'Просмотр',
                        'url' => ["/$this->id/$this->id/view", 'type' => ContentType::NEWS, 'uid' => \Yii::$app->request instanceof Request ? \Yii::$app->request->get('uid') : null],
                            'urlRule' => 'news/<uid>',
                    ],
                ]
            ],
            [
                'label' => 'Страницы',
                'urlRule' => '/',
                'items' => [
                    [
                        'label' => 'Просмотр',
                        'url' => ["/$this->id/$this->id/page-view", 'type' => ContentType::PAGE, 'name' => \Yii::$app->request instanceof Request ? \Yii::$app->request->get('name') : null],
                        //'urlRule' => '<name:[a-zA-Z0-9\/-]+>',
                    ],
                ]
            ],
        ];
    }

}
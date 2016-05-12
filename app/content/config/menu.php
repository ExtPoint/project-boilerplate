<?php

namespace app\content\config;

use app\content\enums\ContentType;
use app\content\models\Page;
use app\profile\enums\UserRole;
use yii\web\Request;

$contentUid = \Yii::$app->request instanceof Request ? \Yii::$app->request->get('uid') : null;
$contentName = \Yii::$app->request instanceof Request ? \Yii::$app->request->get('name') : null;

return array_merge(
    [
        'admin' => [
            'label' => 'Администрирование',
            'roles' => UserRole::ADMIN,
            'items' => array_merge(
                array_map(function ($type) use ($contentUid) {
                    return [
                        'label' => ContentType::getLabel($type),
                        'url' => ["/$this->id/article-admin/index", 'type' => $type],
                        'items' => [
                            [
                                'label' => ContentType::getLabel($type),
                                'url' => ["/$this->id/article-admin/index", 'type' => $type],
                                'urlRule' => "admin/$type",
                            ],
                            [
                                'label' => 'Добавление',
                                'url' => ["/$this->id/article-admin/update", 'type' => $type],
                                'urlRule' => "admin/$type/add",
                            ],
                            [
                                'label' => 'Редактирование',
                                'url' => ["/$this->id/article-admin/update", 'type' => $type, 'uid' => $contentUid],
                                'urlRule' => "admin/$type/update/<uid>",
                            ],
                        ],
                    ];
                }, ContentType::getKeys()),
                [
                    [
                        'label' => 'Страницы',
                        'url' => ["/$this->id/page-admin/index"],
                        'items' => [
                            [
                                'label' => 'Страницы',
                                'url' => ["/$this->id/page-admin/index"],
                                'urlRule' => 'admin/pages'
                            ],
                            [
                                'label' => 'Добавление',
                                'url' => ["/$this->id/page-admin/create"],
                                'urlRule' => 'admin/pages/update',
                            ],
                            [
                                'label' => 'Редактирование',
                                'url' => ["/$this->id/page-admin/update", 'uid' => $contentUid],
                                'urlRule' => 'admin/pages/update/<uid>',
                            ],
                        ],
                    ],
                    [
                        'label' => 'Тексты',
                        'url' => ["/$this->id/text-section-admin/index"],
                        'items' => [
                            [
                                'label' => 'Тексты',
                                'url' => ["/$this->id/text-section-admin/index"],
                                'urlRule' => 'admin/content/texts'
                            ],
                            [
                                'label' => 'Добавление',
                                'url' => ["/$this->id/text-section-admin/update"],
                                'urlRule' => 'admin/content/texts/add',
                            ],
                            [
                                'label' => 'Редактирование',
                                'url' => ["/$this->id/text-section-admin/update", 'uid' => $contentUid],
                                'urlRule' => 'admin/content/texts/update/<uid>',
                            ],
                        ],
                    ],
                ]
            )
        ],
        [
            'label' => 'Страницы',
            'urlRule' => '/',
            'visible' => false,
            'items' => [
                [
                    'label' => 'Просмотр',
                    'url' => ["/$this->id/page/page-view", 'name' => $contentName],
                ],
            ]
        ],
    ], array_map(function ($type) use ($contentUid) {
        return [
            'label' => ContentType::getLabel($type),
            'url' => ["/$this->id/article/index", 'type' => $type],
            'urlRule' => $type,
            'items' => [
                [
                    'label' => 'Просмотр',
                    'url' => ["/$this->id/article/view", 'type' => $type, 'uid' => $contentUid],
                    'urlRule' => "$type/<uid>",
                ],
            ]
        ];
    }, ContentType::getKeys()),
    Page::getMenuItems()
);
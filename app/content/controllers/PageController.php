<?php

namespace app\content\controllers;

use app\content\models\Page;
use app\core\base\AppController;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Request;

class PageController extends AppController {

    public static function coreMenus() {
        $contentName = \Yii::$app->request instanceof Request ? \Yii::$app->request->get('uid') : null;
        return [
            'label' => 'Страницы',
            'urlRule' => '/',
            'visible' => false,
            'items' => [
                [
                    'label' => 'Просмотр',
                    'url' => ["/content/page/page-view", 'uid' => $contentName],
                ],
            ]
        ];
    }
    public function actionView($uid) {
        /** @var Page $pageModel */
        $pageModel = Page::findOne(['uid' => $uid]);
        if (!$pageModel) {
            throw new NotFoundHttpException(Yii::t('app', 'Страница не найдена'));
        }

        Yii::$app->megaMenu->getActiveItem()->label = $pageModel->title;
        return $this->render('view', [
            'pageModel' => $pageModel,
        ]);
    }

}

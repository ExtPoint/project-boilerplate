<?php

namespace app\content\controllers;

use app\content\models\Page;
use app\core\base\AppController;
use extpoint\megamenu\MenuHelper;
use Yii;
use yii\web\NotFoundHttpException;

class PageController extends AppController {

    public static function coreMenuItem() {
        return [
            'label' => 'Страницы',
            'urlRule' => '/',
            'visible' => false,
            'items' => [
                [
                    'label' => 'Просмотр',
                    'url' => ["/content/page/page-view", 'name' => MenuHelper::paramGet('name')],
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

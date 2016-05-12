<?php

namespace app\content\controllers;

use app\content\models\Page;
use app\core\base\AppController;
use Yii;
use yii\web\NotFoundHttpException;

class PageController extends AppController {

    public function actionView($name) {
        /** @var Page $pageModel */
        $pageModel = Page::findOne(['name' => $name]);
        if (!$pageModel) {
            throw new NotFoundHttpException(Yii::t('app', 'Страница не найдена'));
        }

        Yii::$app->megaMenu->getActiveItem()->label = $pageModel->title;
        return $this->render('view', [
            'pageModel' => $pageModel,
        ]);
    }

}

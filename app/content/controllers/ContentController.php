<?php

namespace app\content\controllers;

use app\content\forms\ContentSearch;
use app\content\models\Content;
use app\content\models\ContentPage;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ContentController extends Controller {

    public function actionIndex($type) {
        $searchModel = new ContentSearch();
        $searchModel->type = $type;
        $contentDataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $contentDataProvider->query->andWhere(['isPublished' => true]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'contentDataProvider' => $contentDataProvider,
        ]);
    }

    public function actionView($type, $uid) {
        /** @var Content $contentModel */
        $contentModel = Content::findOne($uid);
        if (!$contentModel) {
            throw new NotFoundHttpException();
        }

        return $this->render('view', [
            'contentModel' => $contentModel,
        ]);
    }

    public function actionPageView($name) {
        /** @var ContentPage $contentPageModel */
        $contentPageModel = Content::findOne(['name' => $name]);
        if (!$contentPageModel) {
            throw new NotFoundHttpException();
        }

        Yii::$app->megaMenu->getActiveItem()->label = $contentPageModel->title;
        return $this->render('page-view', [
            'contentPageModel' => $contentPageModel,
        ]);
    }

}

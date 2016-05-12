<?php

namespace app\content\controllers;

use app\content\forms\ArticleSearch;
use app\content\models\Article;
use app\core\base\AppController;
use Yii;
use yii\web\NotFoundHttpException;

class ArticleController extends AppController {

    public function actionIndex($type) {
        $searchModel = new ArticleSearch();
        $searchModel->type = $type;
        $contentDataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $contentDataProvider->query->andWhere(['isPublished' => true]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'contentDataProvider' => $contentDataProvider,
        ]);
    }

    public function actionView($type, $uid) {
        /** @var Article $contentModel */
        $contentModel = Article::findOne($uid);
        if (!$contentModel) {
            throw new NotFoundHttpException();
        }

        return $this->render('view', [
            'contentModel' => $contentModel,
        ]);
    }

}

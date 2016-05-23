<?php

namespace app\content\controllers;

use app\content\enums\ContentType;
use app\content\forms\ArticleSearch;
use app\content\models\Article;
use app\core\base\AppController;
use extpoint\megamenu\MenuHelper;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Request;

class ArticleController extends AppController {

    public static function coreMenuItem() {
        return array_map(function ($type) {
            return [
                'label' => ContentType::getLabel($type),
                'url' => ["/content/article/index", 'type' => $type],
                'urlRule' => $type,
                'items' => [
                    [
                        'label' => 'Просмотр',
                        'url' => ["/content/article/view", 'type' => $type, 'uid' => MenuHelper::paramGet('uid')],
                        'urlRule' => "$type/<uid>",
                    ],
                ]
            ];
        }, ContentType::getKeys());
    }

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

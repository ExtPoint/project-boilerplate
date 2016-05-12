<?php

namespace app\content\controllers;

use app\content\forms\ArticleSearch;
use app\content\models\Article;
use app\core\base\AppController;
use app\profile\enums\UserRole;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class ArticleAdminController extends AppController {

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [UserRole::ADMIN],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex($type) {
        $searchModel = new ArticleSearch();
        $searchModel->type = $type;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdate($type, $uid = null) {
        /** @var Article $model */
        $model = $uid ?
            Article::findOne($uid) :
            Article::instantiate(['type' => $type]);
        if ($model->isNewRecord) {
            $model->type = $type;
            $model->creatorUserUid = Yii::$app->user->id;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'type' => $type]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id) {
        $model = Article::findOne($id);
        $model->delete();
        return $this->redirect(['index', 'type' => $model->type]);
    }

}

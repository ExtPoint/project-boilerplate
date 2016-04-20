<?php

namespace app\content\controllers;

use app\content\enums\ContentType;
use app\content\models\ContentText;
use app\profile\enums\UserRole;
use Yii;
use app\content\models\Content;
use app\content\forms\ContentSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class ContentAdminController extends Controller {

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
        $searchModel = new ContentSearch();
        $searchModel->type = $type;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id) {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate($type) {
        $model = Content::instantiate(['type' => $type]);
        $model->type = $type;
        $model->creatorUserUid = Yii::$app->user->uid;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if ($type == ContentType::TEXT && Yii::$app->request->post('createMigration')) {
                $model->createMigration();
            }
            return $this->redirect(['index', 'type' => $model->type]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($uid) {
        $model = $this->findModel($uid);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'type' => $model->type]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id) {
        $model = $this->findModel($id);
        $model->delete();
        return $this->redirect(['index', 'type' => $model->type]);
    }

    /**
     * @param string $id
     * @return Content the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Content::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

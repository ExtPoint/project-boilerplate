<?php

namespace app\content\controllers;

use app\content\forms\TextSectionSearch;
use app\content\models\TextSection;
use app\core\base\AppController;
use app\profile\enums\UserRole;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class TextSectionAdminController extends AppController {

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

    public function actionIndex() {
        $searchModel = new TextSectionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdate($uid = null) {
        $model = $uid ?
            TextSection::findOne($uid) :
            new TextSection([
                'creatorUserUid' => Yii::$app->user->id,
            ]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if (Yii::$app->request->post('createMigration')) {
                $model->createMigration();
            }
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id) {
        $model = TextSection::findOne($id);
        if ($model) {
            $model->delete();
        }
        return $this->redirect(['index']);
    }

}

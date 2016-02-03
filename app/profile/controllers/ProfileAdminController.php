<?php

namespace app\profile\controllers;

use app\profile\enums\UserRole;
use app\profile\forms\UserSearch;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * AdminController implements the CRUD actions for User model.
 */
class ProfileAdminController extends Controller {

    public function behaviors() {
        return [
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
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

}

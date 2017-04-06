<?php

namespace app\profile\controllers;

use app\core\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ProfileController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                    ],
                ],
            ],
        ];
    }

    /**
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionIndex() {
        return $this->actionView(Yii::$app->user->id);
    }

    /**
     * @param string $userId
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($userId = null) {
        /** @var User $userModel */
        $userModel = $userId ? User::findOne($userId) : Yii::$app->user->model;
        if (!$userModel) {
            throw new NotFoundHttpException();
        }

        Yii::$app->megaMenu->getActiveItem()->label = $userModel->name;
        return $this->render('view', [
            'userModel' => $userModel,
        ]);
    }

}

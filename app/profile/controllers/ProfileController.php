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
        return $this->actionView(Yii::$app->user->uid);
    }

    /**
     * @param string $userUid
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($userUid) {
        $userModel = User::findOne($userUid);
        if (!$userModel) {
            throw new NotFoundHttpException();
        }

        return $this->render('view', [
            'userModel' => $userModel,
        ]);
    }

}

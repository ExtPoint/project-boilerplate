<?php

namespace app\auth\controllers;

use app\auth\models\LoginForm;
use app\auth\models\RegistrationForm;
use app\core\base\AppController;
use yii\filters\AccessControl;

class AuthController extends AppController {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionLogin() {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(\Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionRegistration() {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new RegistrationForm();

        if ($model->load(\Yii::$app->request->post()) && $model->register()) {
            // Auto login
            $loginModel = new LoginForm();
            $loginModel->username = $model->email;
            $loginModel->password = $model->password;
            $loginModel->login();

            return $this->goHome();
        }

        return $this->render('registration', [
            'model' => $model,
        ]);
    }

    public function actionAgreement() {
        return $this->render('agreement');
    }

    public function actionLogout() {
        \Yii::$app->user->logout();

        return $this->goHome();
    }
}

<?php

namespace app\auth\controllers;

use app\auth\models\SocialConnection;
use app\core\models\User;
use Yii;
use app\auth\models\LoginForm;
use app\auth\models\RegistrationForm;
use app\core\base\AppController;
use yii\authclient\BaseClient;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

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

    public function actions()
    {
        return [
            'social' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }

    /**
     * It is called when the user has been successfully authenticated through an external service.
     * @param BaseClient $client
     * @return mixed
     */
    public function onAuthSuccess($client)
    {
        $attributes = $client->getUserAttributes();
        $id = (string)ArrayHelper::getValue($attributes, 'id');

        /* @var SocialConnection $socialConnection */
        $socialConnection = SocialConnection::find()->where([
            'source' => $client->getId(),
            'sourceId' => $id,
        ])->one();

        if (Yii::$app->user->isGuest) {
            if ($socialConnection && $socialConnection->userUid) {
                // login
                Yii::$app->user->login($socialConnection->user);
                return $this->redirect('/');
            }
            else if ($socialConnection) {
                //registration
                return $this->redirect(['/auth/auth/registration', 'source' => $client->getId(), 'sourceId' => $id]);
            }
            else {
                $socialConnection = new SocialConnection([
                    'source' => $client->getId(),
                    'sourceId' => $id,
                ]);
                $socialConnection->saveOrPanic();

                // registration
                return $this->redirect(['/auth/auth/registration', 'source' => $client->getId(), 'sourceId' => $id]);
            }
        }
        else { // user already logged in
            if (!$socialConnection) {
                // add socialConnection provider
                $socialConnection = new SocialConnection([
                    'userUid' => Yii::$app->user->uid,
                    'source' => $client->getId(),
                    'sourceId' => $id,
                ]);
                $socialConnection->saveOrPanic();
                \Yii::$app->session->setFlash('success', \Yii::t('app', 'Social account success added!'));
                return $this->redirect(['/profile/edit']);
            }

            return $this->redirect('/');
        }
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

            $params = Yii::$app->request->queryParams;
            if(!empty($params['source']) && !empty($params['sourceId'])){
                $socialParam = [
                    'source' => $params['source'],
                    'sourceId' => $params['sourceId'],
                ];

                /** @var SocialConnection $socialConnection */
                $socialConnection = SocialConnection::findOne($socialParam)
                    ?: new SocialConnection($socialParam);
                $socialConnection->userUid = \Yii::$app->user->model->uid;
                $socialConnection->saveOrPanic();
            }

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

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
        $email = ArrayHelper::getValue($attributes, 'email');
        $id = ArrayHelper::getValue($attributes, 'id');
        $nickname = ArrayHelper::getValue($attributes, 'login');

        /* @var SocialConnection $socialConnection */
        $socialConnection = SocialConnection::find()->where([
            'source' => $client->getId(),
            'sourceId' => $id,
        ])->one();

        if (Yii::$app->user->isGuest) {
            if ($socialConnection && $socialConnection->userUid) {
                // login
                Yii::$app->user->login($socialConnection->user);
                return $this->redirect(['/']);
            }
            else if ($socialConnection) {
                //registration
                $this->redirect(['/auth/auth/registration']);
                //add userId in socialConnection
                //return //TODO: высылаем на страницу регистрации
            }
            else {
                // registration
                $this->redirect(['/auth/auth/registration']);
                /*if ($email !== null && User::find()->where(['email' => $email])->exists()) {
                    $response = Yii::$app->response;
                    $response->content = \t('Error: email already registered'); // TODO: Add friendly message
                    return $response;
                }
                elseif (!$email) {
                    $response = Yii::$app->response;
                    $response->content = \t('Error: email already registered'); // TODO: request email
                    return $response;
                }
                else {
                    $investorModel = new QueuedInvestor([
                        'name' => $nickname,
                        'email' => $email,
                    ]);
                    if (!$investorModel->save()) {
                        $response = Yii::$app->response;
                        $response->content = implode('<br>',
                            array_map('htmlspecialchars', $investorModel->errors)
                        );
                        return $response;
                    }

                    $socialConnection = new SocialConnection([
                        'userUid' => $investorModel->uid,
                        'source' => $client->getId(),
                        'sourceId' => (string)$id,
                    ]);

                    $socialConnection->saveOrPanic();

                    return $this->redirect(['/queue/queue/private', 'ref' => $investorModel->refPrivate]);
                }*/
            }
        }
        else { // user already logged in
            if (!$socialConnection) { // add socialConnection provider
                $socialConnection = new SocialConnection([
                    'userUid' => Yii::$app->user->id,
                    'source' => $client->getId(),
                    'sourceId' => (string)$attributes['id'],
                ]);
                $socialConnection->saveOrPanic();
            }

            return $this->redirect(['/']);
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

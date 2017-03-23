<?php

namespace app\profile\controllers;

use app\core\models\User;
use app\profile\forms\PasswordUpdate;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class ProfileEditController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex($userId = null) {
        $model = $userId ? User::findOne($userId) : Yii::$app->user->model;

        if ($model->load(Yii::$app->request->post()) && $model->info->load(Yii::$app->request->post())
            && $model->validate() && $model->info->validate()
        ) {
            if ($model->info->firstName || $model->info->lastName) {
                $model->name = implode(' ', array_filter([
                    $model->info->firstName,
                    $model->info->lastName
                ]));
            }

            if ($model->save() && $model->info->save(false)) {
                \Yii::$app->session->setFlash('success', 'Изменения профиля сохранены!');
                return $this->refresh();
            }
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    public function actionPassword($userId = null) {
        $form = new PasswordUpdate();
        $form->user = $userId ? User::findOne($userId) : Yii::$app->user->model;

        if ($form->load(Yii::$app->request->post()) && $form->change()) {
            \Yii::$app->session->setFlash('success', 'Пароль успешно изменен!');
            return $this->refresh();
        }

        return $this->render('password', [
            'model' => $form,
        ]);
    }


}

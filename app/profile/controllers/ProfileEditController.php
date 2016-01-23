<?php

namespace app\profile\controllers;

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

    /**
     * @return string
     */
    public function actionIndex()
    {
        $model = Yii::$app->user->model;

        if ($model->load(Yii::$app->request->post()) && $model->info->load(Yii::$app->request->post())
            && $model->validate() && $model->info->validate()
        ) {
            if ($model->info->firstName || $model->info->lastName) {
                $model->name = implode(' ', array_filter([
                    $model->info->firstName,
                    $model->info->lastName ? mb_substr($model->info->lastName, 0, 1, 'utf8') . '.' : ''
                ]));
            }

            //$resources = ResourceLibraryModule::getInstance()->uploadImageProcess(reset($_FILES), 'profile');
            //if (!empty($resources)) {
//                $model->photo = $resources[0]->uid;
//            }

            if ($model->save() && $model->info->save(false)) {
                \Yii::$app->session->setFlash('success', 'Изменения профиля сохранены!');
                return $this->refresh();
            }
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * @return string
     */
    public function actionPassword()
    {
        $form = new PasswordUpdate();
        $form->user = Yii::$app->user->model;

        if ($form->load(Yii::$app->request->post()) && $form->change()) {
            \Yii::$app->session->setFlash('success', 'Пароль успешно изменен!');
            return $this->refresh();
        }

        return $this->render('password', [
            'model' => $form,
        ]);
    }

    
}

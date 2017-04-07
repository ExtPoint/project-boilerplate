<?php

namespace app\profile\admin\controllers;

use Yii;
use app\core\base\AppController;
use app\core\models\User;
use app\profile\admin\forms\UserSearch;
use yii\web\ForbiddenHttpException;

class UsersManageController extends AppController
{
    public static function coreMenuItems()
    {
        return [
            [
                'label' => 'Пользователи',
                'url' => ['/profile/admin/users-manage/index'],
                'urlRule' => 'admin/users',
                'roles' => 'admin',
                'items' => [
                    [
                        'label' => 'Добавление',
                        'url' => ['/profile/admin/users-manage/create'],
                        'urlRule' => 'admin/users/create',
                    ],
                    [
                        'label' => 'Редактирование',
                        'url' => ['/profile/admin/users-manage/update', ':id'],
                        'urlRule' => 'admin/users/update/<id:\d+>',
                    ],
                    [
                        'label' => 'Просмотр',
                        'url' => ['/profile/admin/users-manage/view', ':id'],
                        'urlRule' => 'admin/users/<id:\d+>',
                    ],
                    [
                        'url' => ['/profile/admin/users-manage/delete', ':id'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $model = User::findOrPanic($id);
        if (!$model->canView(Yii::$app->user->model)) {
            throw new ForbiddenHttpException();
        }
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionCreate()
    {
        $model = new User();
        if ($model->load(Yii::$app->request->post()) && $model->canCreate(Yii::$app->user->model) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Запись добавлена');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = User::findOrPanic($id);
        if ($model->load(Yii::$app->request->post()) && $model->canUpdate(Yii::$app->user->model) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Запись обновлена');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $model = User::findOrPanic($id);
        if ($model->canDelete(Yii::$app->user->model)) {
            $model->deleteOrPanic();
        } else {
            throw new ForbiddenHttpException();
        }
        return $this->redirect(['index']);
    }

}

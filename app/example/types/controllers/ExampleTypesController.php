<?php

namespace app\example\types\controllers;

use Yii;
use app\core\base\AppController;
use app\example\types\models\Game;
use app\example\types\forms\GameSearch;
use yii\web\ForbiddenHttpException;

class ExampleTypesController extends AppController
{
    public static function coreMenuItems()
    {
        return [
            [
                'label' => 'Example of meta item types',
                'url' => ['/example/types/example-types/index'],
                'urlRule' => 'example/types',
                'items' => [
                    [
                        'label' => 'Добавление',
                        'url' => ['/example/types/example-types/create'],
                        'urlRule' => 'example/types/create',
                    ],
                    [
                        'label' => 'Редактирование',
                        'url' => ['/example/types/example-types/update'],
                        'urlRule' => 'example/types/update/<gameId:\d+>',
                    ],
                    [
                        'label' => 'Просмотр',
                        'url' => ['/example/types/example-types/view'],
                        'urlRule' => 'example/types/<gameId:\d+>',
                        'modelClass' => Game::className(),
                    ],
                    [
                        'url' => ['/example/types/example-types/delete'],
                        'urlRule' => 'example/types/delete/<gameId:\d+>',
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new GameSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($gameId)
    {
        $model = Game::findOrPanic($gameId);
        if (!$model->canView(Yii::$app->user->model)) {
            throw new ForbiddenHttpException();
        }
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionCreate()
    {
        $model = new Game();

        if ($model->load(Yii::$app->request->post()) && $model->canCreate(Yii::$app->user->model) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Запись добавлена');
            return $this->redirect(['view', 'gameId' => $model->primaryKey]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($gameId)
    {
        $model = Game::findOrPanic($gameId);
        $model->fillManyMany();

        if ($model->load(Yii::$app->request->post()) && $model->canUpdate(Yii::$app->user->model) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Запись обновлена');
            return $this->redirect(['view', 'gameId' => $model->primaryKey]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($gameId)
    {
        $model = Game::findOrPanic($gameId);
        if ($model->canDelete(Yii::$app->user->model)) {
            $model->deleteOrPanic();
        } else {
            throw new ForbiddenHttpException();
        }
        return $this->redirect(['index']);
    }

}

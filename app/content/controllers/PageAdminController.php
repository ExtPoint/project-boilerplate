<?php

namespace app\content\controllers;

use app\content\forms\PageSearch;
use app\content\models\Page;
use app\core\base\AppController;
use app\profile\enums\UserRole;
use extpoint\megamenu\MenuHelper;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Request;

class PageAdminController extends AppController {

    public static function coreMenuItem() {
        return [
            'label' => 'Страницы',
            'url' => ["/content/page-admin/index"],
            'items' => [
                [
                    'label' => 'Страницы',
                    'url' => ["/content/page-admin/index"],
                    'urlRule' => 'admin/pages'
                ],
                [
                    'label' => 'Добавление',
                    'url' => ["/content/page-admin/create"],
                    'urlRule' => 'admin/pages/update',
                ],
                [
                    'label' => 'Редактирование',
                    'url' => ["/content/page-admin/update", 'uid' => MenuHelper::paramGet('uid')],
                    'urlRule' => 'admin/pages/update/<uid>',
                ],
            ],
        ];
    }

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
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
        $searchModel = new PageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdate($uid = null) {
        $model = $uid ?
            Page::findOne($uid) :
            new Page([
                'creatorUserUid' => Yii::$app->user->id,
            ]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id) {
        $model = Page::findOne($id);
        if ($model) {
            $model->delete();
        }
        return $this->redirect(['index']);
    }

}

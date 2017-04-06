<?php

namespace app\profile\admin\controllers;

use app\core\base\AppController;
use app\profile\forms\UserSearch;
use Yii;

class ProfileManageController extends AppController
{
    public static function coreMenuItems()
    {
        return [
            [
                'label' => 'Пользователи',
                'url' => ['/profile/admin/profile-manage/index'],
                'urlRule' => 'admin/profile',
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

}

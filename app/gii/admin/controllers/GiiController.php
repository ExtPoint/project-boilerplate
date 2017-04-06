<?php

namespace app\gii\admin\controllers;

use app\core\base\AppController;
use app\gii\admin\generators\model\ModelGenerator;
use app\gii\admin\generators\crud\CrudGenerator;
use app\gii\admin\generators\module\ModuleGenerator;
use app\gii\admin\helpers\GiiHelper;
use yii\data\ArrayDataProvider;

class GiiController extends AppController
{
    public static function coreMenuItems() {
        return [
            'gii' => [
                'label' => 'Генератор кода',
                'url' => ['/gii/admin/gii/index'],
                'urlRule' => 'admin/gii',
                'order' => 500,
                'items' => [
                    [
                        'label' => 'Модели',
                        'url' => ['/gii/admin/gii/model'],
                        'urlRule' => 'admin/gii/model',
                    ],
                    [
                        'label' => 'CRUD',
                        'url' => ['/gii/admin/gii/crud'],
                        'urlRule' => 'admin/gii/crud',
                    ]
                ]
            ],
        ];
    }

    public function actionIndex()
    {
        if (\Yii::$app->request->post('create-module') === '') {
            $moduleId = \Yii::$app->request->post('moduleId');
            if ($moduleId) {
                (new ModuleGenerator([
                    'moduleId' => $moduleId,
                ]))->generate();
            }
        }

        $modelDataProvider = new ArrayDataProvider([
            'allModels' => GiiHelper::getModels(),
        ]);

        return $this->render('index', [
            'modelDataProvider' => $modelDataProvider,
        ]);
    }

    public function actionModel($moduleId = null, $modelName = null)
    {
        if (\Yii::$app->request->isPost) {
            $moduleId = \Yii::$app->request->post('moduleId');
            $modelName = \Yii::$app->request->post('modelName');

            // Check to create module
            if ($moduleId && !GiiHelper::isModuleExists($moduleId)) {
                (new ModuleGenerator([
                    'moduleId' => $moduleId,
                ]))->generate();
            }

            // Update model
            if ($moduleId && $modelName) {
                (new ModelGenerator([
                    'moduleId' => $moduleId,
                    'modelName' => $modelName,
                    'tableName' => \Yii::$app->request->post('tableName'),
                    'meta' => \Yii::$app->request->post('meta'),
                    'relations' => \Yii::$app->request->post('relations'),
                ]))->generate();

                return $this->redirect(['model', 'moduleId' => $moduleId, 'modelName' => $modelName]);
            }
        }

        return $this->render('model', [
            'initialValues' => [
                'moduleId' => $moduleId,
                'modelName' => $modelName,
            ],
        ]);
    }

    public function actionCrud($moduleId = null, $modelName = null)
    {
        if (\Yii::$app->request->isPost) {
            $moduleId = \Yii::$app->request->post('moduleId');
            $modelName = \Yii::$app->request->post('modelName');

            // Check to create module
            if ($moduleId && !GiiHelper::isModuleExists($moduleId)) {
                (new CrudGenerator([
                    'moduleId' => $moduleId,
                    'modelName' => $modelName,
                    'name' => \Yii::$app->request->post('name'),
                ]))->generate();

                return $this->redirect(['crud', 'moduleId' => $moduleId, 'modelName' => $modelName]);
            }
        }

        return $this->render('crud', [
            'initialValues' => [
                'moduleId' => $moduleId,
                'modelName' => $modelName,
            ],
        ]);
    }

}

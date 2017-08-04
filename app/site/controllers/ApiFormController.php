<?php

namespace app\site\controllers;

use app\address\models\Country;
use app\address\models\MetroStation;
use app\address\models\Region;
use app\catalog\models\Manufacturer;
use app\core\base\AppController;
use app\core\models\User;
use app\example\types\models\Game;
use extpoint\yii2\base\Model;
use extpoint\yii2\file\models\File;
use extpoint\yii2\types\RelationType;
use yii\base\Exception;
use yii\helpers\ArrayHelper;
use yii\web\Response;

class ApiFormController extends AppController
{
    public static function coreMenuItems()
    {
        return [
            [
                'label' => 'API Form',
                'url' => ['/site/api-form/fetch'],
                'urlRule' => 'api/form/fetch',
                'visible' => false,
            ],
            [
                'label' => 'API Form',
                'url' => ['/site/api-form/auto-complete'],
                'urlRule' => 'api/form/auto-complete',
                'visible' => false,
            ],
        ];
    }

    public static $modelWhiteList = [
        'app\example\types\models\Player',
    ];

    public function actionFetch()
    {
        $requests = \Yii::$app->request->post('requests', []);
        $entries = [];

        foreach ($requests as $request) {
            /** @type Model $model */
            $model = ArrayHelper::getValue($request, 'model');
            $fieldId = ArrayHelper::getValue($request, 'fieldId');
            $attribute = ArrayHelper::getValue($request, 'attribute');
            $ids = ArrayHelper::getValue($request, 'ids', []);

            if (count($ids) === 0 || !$fieldId || !$attribute || !$model) {
                continue;
            }

            // Get app type
            $meta = $model::meta();
            $appType = ArrayHelper::getValue($meta, $attribute . '.appType', 'string');

            switch ($appType) {
                case 'relation':
                    $relationName = ArrayHelper::getValue($meta, $attribute . '.' . RelationType::OPTION_RELATION_NAME);
                    if ($relationName) {
                        /** @var Model $modelInstance */
                        $modelInstance = new $model();

                        /** @var Model $modelClass */
                        $modelClass = $modelInstance->getRelation($relationName)->modelClass;
                        if (!in_array($modelClass, static::$modelWhiteList)) {
                            throw new Exception('Model `' . $modelClass::className() . '` is not in white list in api form controller.');
                        }

                        foreach ($modelClass::findAll($ids) as $model) {
                            $entries[$fieldId][] = [
                                'id' => $model->primaryKey,
                                'label' => $model->modelLabel,
                            ];
                        }
                    }
                    break;

                case 'file':
                case 'files':
                    foreach (File::findAll($ids) as $model) {
                        /** @var File $model */
                        $entries[$fieldId][] = [
                            'id' => $model->primaryKey,
                            'uid' => $model->uid,
                            'path' => $model->title,
                            'type' => $model->fileMimeType,
                            'bytesUploaded' => $model->fileSize,
                            'bytesUploadEnd' => $model->fileSize,
                            'bytesTotal' => $model->fileSize,
                            'resultHttpMessage' => $model->getExtendedAttributes(ArrayHelper::getValue($request, 'processor')),
                        ];
                    }
                    break;

                default:
                    throw new Exception('Unknown app type for api form controller: ' . $appType);
            }

            /** @type Model $modelClass */
        }

        \Yii::$app->response->format = Response::FORMAT_JSON;
        return $entries;
    }

    public function actionAutoComplete()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $model = \Yii::$app->request->post('model');
        $attribute = \Yii::$app->request->post('attribute');
        $queryString = \Yii::$app->request->post('queryString');

        if (!$model || !$attribute || !$queryString) {
            return [];
        }

        // Get app type
        $meta = $model::meta();
        $appType = ArrayHelper::getValue($meta, $attribute . '.appType', 'string');

        switch ($appType) {
            case 'relation':
                $relationName = ArrayHelper::getValue($meta, $attribute . '.' . RelationType::OPTION_LIST_RELATION_NAME);
                if (!$relationName) {
                    throw new Exception('Not found relation "' . $relationName . '" for auto complete api form controller: ' . $appType);
                }

                /** @var Model $modelInstance */
                $modelInstance = new $model();

                /** @var Model $relationModelClass */
                $relationModelClass = $modelInstance->getRelation($relationName)->modelClass;
                if (!in_array($relationModelClass, static::$modelWhiteList)) {
                    throw new Exception('Model `' . $relationModelClass::className() . '` is not in white list in api form controller.');
                }

                $searchAttribute = null;
                /** @var Model $relationModel */
                $relationModel = new $relationModelClass();
                foreach (['title', 'label', 'name'] as $name) {
                    if ($relationModel->hasAttribute($name)) {
                        $searchAttribute = $name;
                    }
                }
                if (!$searchAttribute) {
                    throw new Exception('Not found search attribute for auto complete api form controller: ' . $appType);
                }

                $entries = $relationModelClass::find()
                    ->select(['label' => $searchAttribute, 'id'])
                    ->where(['like', 'LOWER(' . $searchAttribute . ')', mb_strtolower($queryString, 'UTF-8')])
                    ->asArray()
                    ->limit(20)
                    ->all();

                $entries = array_map(function($entry) {
                    $entry['id'] = (int) $entry['id'];
                    return $entry;
                }, $entries);
                break;

            default:
                throw new Exception('Unknown app type for api form controller: ' . $appType);
        }

        return $entries;
    }

}

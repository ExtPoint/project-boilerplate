<?php

namespace app\file\controllers;

use app\file\FileModule;
use app\file\models\File;
use app\core\base\AppController;
use yii\web\NotFoundHttpException;

class DownloadController extends AppController {

    public function actionIndex($uid) {
        /** @var File $file */
        $file = File::findOne($uid);
        if (!$file) {
            throw new NotFoundHttpException();
        }

        \Yii::$app->response->xSendFile($file->path, $file->downloadName, [
            'xHeader' => FileModule::getInstance()->xHeader,
        ]);
    }

}
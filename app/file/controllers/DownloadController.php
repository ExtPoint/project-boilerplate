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

        if (FileModule::getInstance()->xHeader !== false) {
            \Yii::$app->response->xSendFile($file->path, $file->downloadName, [
                'xHeader' => FileModule::getInstance()->xHeader,
            ]);
        } else {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $file->getDownloadName() . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file->path));
            readfile($file->path);
        }
    }

}
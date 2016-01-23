<?php

namespace app\file\controllers;

use app\file\FileModule;
use yii\helpers\Json;
use yii\web\Controller;

class UploadController extends Controller {

    public $enableCsrfValidation = false;

	public function actionIndex() {
        $result = FileModule::getInstance()->upload();
        if (isset($result['errors'])) {
            return Json::encode([
                'error' => implode(', ', $result['errors']),
            ]);
        }

		// Send responses data
		return Json::encode(array_map(
			function ($file) {
				/** @var \app\file\models\File $file */
				return $file->getExtendedAttributes();
			},
			$result
		));
	}

}
<?php

namespace app\comet\controllers;

use app\core\components\AppController;

class ApiController extends AppController {

    public function actionLoad() {
        return json_encode(\Yii::$app->neatComet->server->loadDataLocally(json_decode($_POST['msg'], true)));
    }

}

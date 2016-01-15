<?php

namespace app\comet\controllers;

use yii\web\Controller;

class ApiController extends Controller {

    public function actionLoad() {
        return json_encode(\Yii::$app->neatComet->server->loadDataLocally(json_decode($_POST['msg'], true)));
    }

}

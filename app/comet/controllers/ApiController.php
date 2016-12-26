<?php

namespace app\comet\controllers;

use app\core\base\AppController;

class ApiController extends AppController {

    public function actionLoad() {
        return json_encode(CometModule::getInstance()->neat->server->loadDataLocally(json_decode($_POST['msg'], true)));
    }

}

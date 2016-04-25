<?php

namespace app\comet\controllers;

use app\core\base\AppController;

class CometController extends AppController {

    public function actionIndex() {
        return $this->render('index');
    }

}

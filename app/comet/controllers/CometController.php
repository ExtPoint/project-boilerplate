<?php

namespace app\comet\controllers;

use extpoint\yii2\base\AppController;

class CometController extends AppController {

    public function actionIndex() {
        return $this->render('index');
    }

}

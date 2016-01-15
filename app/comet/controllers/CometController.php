<?php

namespace app\comet\controllers;

use yii\web\Controller;

class CometController extends Controller {

    public function actionIndex() {
        return $this->render('index');
    }

}

<?php

namespace app\gii\admin\widgets\CrudFrom;

use app\core\base\AppWidget;
use app\gii\admin\helpers\GiiHelper;

class CrudFrom extends AppWidget
{
    public $initialValues;

    public function init()
    {
        echo $this->renderReact([
            'initialValues' => !empty($this->initialValues) ? $this->initialValues : null,
            'csrfToken' => \Yii::$app->request->csrfToken,
            'modules' => GiiHelper::getModules(),
            'models' => GiiHelper::getModels(),
        ]);
    }


}
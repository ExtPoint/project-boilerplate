<?php

namespace app\gii\admin\widgets\ModelEditor;

use app\core\base\AppWidget;
use app\gii\admin\helpers\GiiHelper;

class ModelEditor extends AppWidget
{
    public $initialValues;

    public function init()
    {
        echo $this->renderReact([
            'initialValues' => !empty($this->initialValues) ? $this->initialValues : null,
            'csrfToken' => \Yii::$app->request->csrfToken,
            'modules' => GiiHelper::getModules(),
            'models' => GiiHelper::getModels(),
            'tableNames' => GiiHelper::getTableNames(),
            'dbTypes' => GiiHelper::getDbTypes(),
            'fieldWidgets' => GiiHelper::getFieldWidgets(),
            'formatters' => GiiHelper::getFormatters(),
        ]);
    }


}
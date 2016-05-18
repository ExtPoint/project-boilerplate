<?php

namespace app\views;

use app\core\generators\model\ModelGenerator;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $form ActiveForm */
/* @var $generator ModelGenerator */

echo $form->field($generator, 'moduleName')->dropDownList($generator->getModuleNames());
echo $form->field($generator, 'tableName')->dropDownList($generator->getTableNamesList());
echo $form->field($generator, 'modelClass');
echo $form->field($generator, 'ns');

$generator->registerAutoFillJs($this, "
    var tableName = helpers.tableToCamel(inputs.tableName.val());
    var namespace = helpers.getClassNamespace(inputs.moduleName.val());

    if (!isManualChanged.modelClass && tableName) {
        inputs.modelClass.val(tableName);
    }

    if (!isManualChanged.ns && namespace) {
        inputs.ns.val(namespace + '\\\\models');
    }
");
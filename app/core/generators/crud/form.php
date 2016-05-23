<?php

/* @var $this \yii\web\View */
/* @var $form \app\core\widgets\AppActiveForm */
/* @var $generator \app\core\generators\crud\CrudGenerator */

echo $form->field($generator, 'modelClass')->dropDownList($generator->getModelNames());
echo $form->field($generator, 'controllerClass');

$generator->registerAutoFillJs($this, "
    var namespace = helpers.getClassNamespace(inputs.modelClass.val()).replace(/\\\\models$/, '');
    var modelName = helpers.getClassName(inputs.modelClass.val());

    if (!isManualChanged.controllerClass) {
        inputs.controllerClass.val(namespace + '\\\\controllers\\\\' + modelName + 'AdminController');
    }
");
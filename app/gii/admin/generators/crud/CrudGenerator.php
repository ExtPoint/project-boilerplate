<?php

namespace app\gii\admin\generators\crud;

use yii\gii\CodeFile;
use yii\gii\Generator;

class CrudGenerator extends Generator
{
    public $moduleId;
    public $modelName;

    public function getName() {
        return 'crud';
    }

    public function requiredTemplates()
    {
        return ['search', 'controller'];
    }

    /**
     * @inheritdoc
     */
    public function generate()
    {
        list($moduleId, $subModuleId) = strpos($this->moduleId, '.')
            ? explode('.', $this->moduleId)
            : [$this->moduleId, ''];

        (new CodeFile(
            \Yii::getAlias('@app') . '/' . $moduleId . '/' . ucfirst($moduleId) . 'Module.php',
            $this->render('module.php', [
                'namespace' => 'app\\' . $moduleId,
                'className' => ucfirst($moduleId) . 'Module',
            ])
        ))->save();
        \Yii::$app->session->addFlash('success', "Создан модуль $moduleId");
    }
}
<?php

namespace app\gii\admin\generators\module;

use yii\gii\CodeFile;
use yii\gii\Generator;

class ModuleGenerator extends Generator
{
    public $moduleId;

    public function getName() {
        return 'module';
    }

    public function requiredTemplates()
    {
        return ['adminModule', 'module'];
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
        if ($subModuleId) {
            (new CodeFile(
                \Yii::getAlias('@app') . '/' . $moduleId . '/' . $subModuleId . '/' . ucfirst($moduleId) . ucfirst($subModuleId) . 'Module.php',
                $this->render($subModuleId === 'admin' ? 'adminModule.php' : 'module.php', [
                    'namespace' => 'app\\' . $moduleId . '\\' . $subModuleId,
                    'className' => ucfirst($moduleId) . ucfirst($subModuleId) . 'Module',
                ])
            ))->save();
            \Yii::$app->session->addFlash('success', "Создан модуль $moduleId.$subModuleId");
        }
    }
}
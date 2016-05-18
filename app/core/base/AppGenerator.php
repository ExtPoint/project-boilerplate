<?php

namespace app\core\base;

use yii\base\Module;
use yii\gii\Generator;
use yii\web\JqueryAsset;
use yii\web\View;

abstract class AppGenerator extends Generator {

    public $moduleName;

    /**
     * @inheritdoc
     */
    public function rules() {
        return array_merge(parent::rules(), [
            //['moduleName', 'required'],
            //['moduleName', 'in', 'range' => array_keys($this->getModuleNames())],
        ]);
    }

    public function getModuleNames() {
        $moduleNames = ['' => ''];
        foreach (\Yii::$app->modules as $id => $m) {
            /** @var Module $m */
            $className = is_array($m) ? $m['class'] : $m->className();

            // Filter out Yii modules
            if (substr($className, 0, 3) == 'yii') {
                continue;
            }

            $moduleNames[$className] = $id;
        }
        asort($moduleNames);
        return $moduleNames;
    }

    public function getTableNamesList() {
        $names = ['' => ''];
        foreach (\Yii::$app->db->schema->getTableNames() as $name) {
            $names[$name] = $name;
        }
        return $names;
    }

    /**
     * @param View $view
     */
    public function registerAutoFillJs($view, $js) {
        JqueryAsset::register($view);
        $view->registerJs('window.generatorAutoFill = function(helpers, inputs, isManualChanged) {' . $js . '}', View::POS_END);
        $view->registerJs(file_get_contents(__DIR__ . '/../assets/generator-auto-fill.js'));
    }

}
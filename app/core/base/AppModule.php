<?php

namespace app\core\base;

use yii\base\BootstrapInterface;
use yii\base\Exception;
use yii\base\Module;
use yii\helpers\ArrayHelper;

/**
 * @package app\core\base
 */
class AppModule extends Module implements BootstrapInterface {

    public $layout = '@app/core/layouts/web';

    /**
     * @return static
     * @throws Exception
     */
    public static function getInstance() {
        if (!preg_match('/([^\\\]+)Module$/', static::className(), $match)) {
            throw new Exception('Cannot auto get module id by class name: ' . static::className());
        }

        $id = lcfirst($match[1]);
        return \Yii::$app->getModule($id);
    }

    /**
     * @inheritdoc
     */
    public function bootstrap($app) {
        $app->getUrlManager()->addRules($this->coreUrlRules(), false);
    }

    /**
     * @inheritdoc
     */
    public function init() {
        // Submodules support
        $ids = [];
        $module = $this;
        while (true) {
            if (!$module || $module instanceof \yii\base\Application) {
                break;
            }
            $ids[] = $module->id;
            $module = $module->module;
        }
        $this->controllerNamespace = 'app\\' . implode('\\', array_reverse($ids)) . '\controllers';

        parent::init();

        $this->initCoreComponents();
    }

    protected function initCoreComponents() {
        // Create core components
        $coreComponents = $this->coreComponents();
        foreach ($coreComponents as $id => $config) {
            if (is_string($this->$id)) {
                $config = ['class' => $this->$id];
            } elseif (is_array($this->$id)) {
                $config = ArrayHelper::merge($config, $this->$id);
            }
            $config['module'] = $this;
            $this->$id = \Yii::createObject($config);
        }
    }

    protected function coreComponents() {
        return [];
    }

    protected function coreUrlRules() {
        return [];
    }

}
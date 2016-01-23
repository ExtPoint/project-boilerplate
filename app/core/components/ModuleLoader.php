<?php

namespace app\core\components;

require_once __DIR__ . '/../base/AppModule.php';

class ModuleLoader {

    public static $skipFolders = [
        'config',
    ];

    private static $classes;

    public static function getBootstrap() {
        $names = [];
        foreach (self::getClasses() as $name => $moduleClass) {
            if (is_subclass_of($moduleClass, '\yii\base\BootstrapInterface')) {
                $names[] = $name;
            }
        }
        return $names;
    }

    public static function getConfig() {
        $config = [];
        foreach (self::getClasses() as $name => $moduleClass) {
            $config[$name] = [
                'class' => $moduleClass,
            ];
        }
        return $config;
    }

    protected static function getAppDir() {
        return dirname(dirname(__DIR__));
    }

    protected static function getClasses() {
        // @todo submodules support or not need?

        if (self::$classes === null) {
            self::$classes = [];

            foreach (scandir(static::getAppDir()) as $dirName) {
                if (substr($dirName, 0, 1) === '.' || in_array($dirName, self::$skipFolders)) {
                    continue;
                }

                $classPath = static::getAppDir() . '/' . $dirName . '/' . ucfirst($dirName) . 'Module.php';
                if (!file_exists($classPath)) {
                    throw new \Exception('Not found module class file: ' . $classPath);
                }
                require_once $classPath;

                $className = '\app\\' . $dirName . '\\' . ucfirst($dirName) . 'Module';
                if (!class_exists($className)) {
                    throw new \Exception('Not found module class: ' . $className);
                }
                if (!is_subclass_of($className, '\app\core\base\AppModule')) {
                    throw new \Exception('Module class `' . $className . '` is not extends from `\app\core\base\AppModule`');
                }

                self::$classes[$dirName] = $className;
            }
        }
        return self::$classes;
    }

}
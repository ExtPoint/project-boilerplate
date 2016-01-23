<?php

require(__DIR__ . '/../../../vendor/yiisoft/yii2/BaseYii.php');
require(__DIR__ . '/WebApplication.php');

/**
 * @property \app\core\components\ContextUser $user
 */
class Yii extends \yii\BaseYii
{
    /**
     * @var \app\core\base\WebApplication|\yii\console\Application
     */
    public static $app;
}

spl_autoload_register(['Yii', 'autoload'], true, true);
Yii::$classMap = require(__DIR__ . '/../../../vendor/yiisoft/yii2/classes.php');
Yii::$container = new yii\di\Container();

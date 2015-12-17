<?php

// Load custom config, if exists
ob_start();
$config = file_exists(__DIR__ . '/config.php') ?
    require __DIR__ . '/config.php' :
    [];
ob_end_clean();
if (empty($config['profile'])) {
    $config['profile'] = 'production';
}

// Init Yii constants
$profiles = ['development' => 'dev', 'production' => 'prod', 'test' => 'test'];
defined('YII_DEBUG') || define('YII_DEBUG', false);
defined('YII_ENV') || define('YII_ENV', isset($profiles[$config['profile']]) ? $profiles[$config['profile']] : 'production');

// Init Yii autoloader
require(__DIR__ . '/vendor/autoload.php');
require(__DIR__ . '/app/core/base/Yii.php');

// Load environment config
$environmentConfigPath = __DIR__ . '/app/config/env/' . $config['profile'] . '.php';
if (file_exists($environmentConfigPath)) {
    $config = \yii\helpers\ArrayHelper::merge(require $environmentConfigPath, $config);
}

unset($config['profile']);
return $config;
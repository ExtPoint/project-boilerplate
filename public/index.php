<?php

// Load config
$config = require dirname(__DIR__) . '/bootstrap.php';
$config = \yii\helpers\ArrayHelper::merge(require dirname(__DIR__) . '/app/config/web.php', $config);

// Run application
(new \app\core\base\WebApplication($config))->run();

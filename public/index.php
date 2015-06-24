<?php

// Load config
$config = require dirname(__DIR__) . '/bootstrap.php';
$config = \yii\helpers\ArrayHelper::merge(require dirname(__DIR__) . '/config/web.php', $config);

// Run application
(new yii\web\Application($config))->run();

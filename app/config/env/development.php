<?php

return [
    'bootstrap' => ['debug', 'gii'],
    'modules' => [
        'debug' => 'yii\debug\Module',
        'gii' => array(
            'class' => 'yii\gii\Module',
            'generators' => [
                'crud' => '\app\core\generators\crud\CrudGenerator',
                'model' => '\app\core\generators\model\ModelGenerator',
            ],
        ),
    ],
];
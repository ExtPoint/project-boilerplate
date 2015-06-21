<?php

return \yii\helpers\ArrayHelper::merge(
    require 'main.php',
    [
        'components' => [
            'request' => [
                'cookieValidationKey' => 'q2%s2~5twSe2OkBJ8H6k6wUI@fe~Ah9|',
            ],
            'user' => [
                'identityClass' => 'app\models\User',
                'enableAutoLogin' => true,
            ],
            'errorHandler' => [
                'errorAction' => 'site/error',
            ],
            'urlManager'=> [
                'showScriptName' => false,
                'enablePrettyUrl' => true,
                //'enableStrictParsing' => true,
                'suffix' => '/',
                'rules' => [
                    '' => 'site/index',
                ],
            ],
        ],
    ]
);
<?php

return \yii\helpers\ArrayHelper::merge(
    require 'main.php',
    [
        'defaultRoute' => 'site/site/index',
        'components' => [
            'request' => [
                'cookieValidationKey' => 'q2%s2~5twSe2OkBJ8H6k6wUI@fe~Ah9|',
                'parsers' => [
                    'application/json' => 'yii\web\JsonParser',
                ],
            ],
            'user' => [
                'class' => '\app\core\components\ContextUser',
                'identityClass' => 'app\core\models\User',
                'enableAutoLogin' => true,
            ],
            'errorHandler' => [
                'errorAction' => 'site/site/error',
            ],
        ],
    ]
);
<?php

namespace app\example\types;

use app\core\base\AppModule;
use app\example\types\controllers\ExampleTypesController;

class ExampleTypesModule extends AppModule
{
    public function coreMenu()
    {
        return [
            'example' => [
                'items' => ExampleTypesController::coreMenuItems(),
            ],
        ];
    }
}

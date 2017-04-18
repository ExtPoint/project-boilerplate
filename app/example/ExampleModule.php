<?php

namespace app\example;

use app\core\base\AppModule;

class ExampleModule extends AppModule
{
    public function coreMenu()
    {
        return [
            'example' => [
                'label' => 'Examples',
            ],
        ];
    }
}

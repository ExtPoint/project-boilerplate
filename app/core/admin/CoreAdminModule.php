<?php

namespace app\core\admin;

use app\core\base\AppModule;

class CoreAdminModule extends AppModule {

    public function coreMenu()
    {
        return [
            'admin' => [
                'label' => 'Панель управления',
                'roles' => '@',
                'redirectToChild' => true,
            ],
        ];
    }

}
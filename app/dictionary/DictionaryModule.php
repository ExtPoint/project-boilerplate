<?php

namespace app\dictionary;

use app\core\base\AppModule;
use app\dictionary\controllers\DictionaryAdminController;
use app\profile\enums\UserRole;

/**
 * dictionary module definition class
 */
class DictionaryModule extends AppModule
{

    public function coreMenus()
    {
        return [

            'admin' => [
                'label' => 'Администрирование',
                'roles' => UserRole::ADMIN,
                'items' => [
                    DictionaryAdminController::coreMenus()
                ]
            ],
        ];
    }

}

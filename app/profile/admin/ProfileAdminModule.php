<?php

namespace app\profile\admin;

use app\core\admin\base\AppAdminModule;
use app\profile\admin\controllers\ProfileManageController;

class ProfileAdminModule extends AppAdminModule {

    public function coreMenu() {
        return [
            'admin' => [
                'items' => ProfileManageController::coreMenuItems()
            ]
        ];
    }

}
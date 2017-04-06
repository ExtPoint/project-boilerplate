<?php

namespace app\gii\admin;

use app\core\admin\base\AppAdminModule;
use app\gii\admin\controllers\GiiController;

class GiiAdminModule extends AppAdminModule
{
    /**
     * @var integer the permission to be set for newly generated code files.
     * This value will be used by PHP chmod function.
     * Defaults to 0666, meaning the file is read-writable by all users.
     */
    public $newFileMode = 0666;

    /**
     * @var integer the permission to be set for newly generated directories.
     * This value will be used by PHP chmod function.
     * Defaults to 0777, meaning the directory can be read, written and executed by all users.
     */
    public $newDirMode = 0777;

    public function coreMenu()
    {
        return [
            'admin' => [
                'items' => GiiController::coreMenuItems()
            ],
        ];
    }
}
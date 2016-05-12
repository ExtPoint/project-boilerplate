<?php

namespace app\content;

use app\content\validators\ContentNameValidator;
use app\core\base\AppModule;
use yii\base\Application;

class ContentModule extends AppModule {

    public function coreMenus() {
        return require __DIR__ . '/config/menu.php';
    }

}
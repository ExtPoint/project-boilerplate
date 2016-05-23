<?php

namespace app\content;

use app\content\controllers\ArticleAdminController;
use app\content\controllers\ArticleController;
use app\content\controllers\PageAdminController;
use app\content\controllers\PageController;
use app\content\controllers\TextSectionAdminController;
use app\content\models\Page;
use app\core\base\AppModule;
use app\profile\enums\UserRole;

class ContentModule extends AppModule {

    public function coreMenu() {
        return array_merge(
            [
                'admin' => [
                    'label' => 'Администрирование',
                    'roles' => UserRole::ADMIN,
                    'items' => array_merge(
                        ArticleAdminController::coreMenuItem(),
                        [
                            PageAdminController::coreMenuItem(),
                            TextSectionAdminController::coreMenuItem(),
                        ]
                    )
                ],
                PageController::coreMenuItem(),
            ], ArticleController::coreMenuItem(),
            Page::getMenuItems()
        );
    }

}
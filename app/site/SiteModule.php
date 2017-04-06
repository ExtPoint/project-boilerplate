<?php

namespace app\site;

use app\core\base\AppModule;

class SiteModule extends AppModule {

    public function coreMenu() {
        return [
            'index' => [
                'label' => 'Главная',
                'url' => ['/site/site/index'],
                'urlRule' => '/',
                'order' => -100,
            ],
            'about' => [
                'label' => 'О сайте',
                'url' => ['/site/site/about'],
                'urlRule' => 'about',
                'order' => -50,
            ],
            [
                'label' => 'Ошибка',
                'url' => ['/site/site/error'],
                'visible' => false,
            ],
        ];
    }

}
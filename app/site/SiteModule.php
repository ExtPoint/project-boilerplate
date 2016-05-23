<?php

namespace app\site;

use app\core\base\AppModule;

class SiteModule extends AppModule {

    public function coreMenu() {
        return [
            [
                'label' => 'Главная',
                'url' => ["/$this->id/site/index"],
                'urlRule' => '',
                'order' => -100,
            ],
            [
                'label' => 'О сайте',
                'url' => ["/$this->id/site/about"],
                'urlRule' => 'about',
                'order' => -50,
            ],
            [
                'label' => 'Ошибка',
                'url' => ["/$this->id/site/error"],
                'visible' => false,
            ],
            [
                'label' => 'Gii',
                'url' => ["/gii/default/index"],
                'visible' => \Yii::$app->hasModule('gii'),
                'order' => 90,
            ],
        ];
    }

}
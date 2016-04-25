<?php

namespace app\site;

use app\core\base\AppModule;

class SiteModule extends AppModule {

    /**
     * @inheritdoc
     */
    public function bootstrap($app) {
        $app->defaultRoute = '/site/site/index';
        parent::bootstrap($app);
    }

    public function coreMenus() {
        return [
            [
                'label' => 'Главная',
                'url' => ["/$this->id/site/index"],
                'urlRule' => '',
            ],
            [
                'label' => 'О сайте',
                'url' => ["/$this->id/site/about"],
                'urlRule' => 'about',
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
            ],
        ];
    }

}
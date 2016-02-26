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

    protected function coreUrlRules() {
        return [
            '' => "$this->id/site/index",
            'about' => "$this->id/site/about",
        ];
    }

    public function coreMenus() {
        $items = [
            ['label' => 'Главная', 'url' => ["/$this->id/site/index"]],
            ['label' => 'О сайте', 'url' => ["/$this->id/site/about"]],
            [
                'label' => 'Ошибка',
                'url' => ["/$this->id/site/error"],
                'visible' => false,
            ],
        ];
        if (\Yii::$app->hasModule('gii')) {
            $items[] = ['label' => 'Gii', 'url' => ["/gii/default/index"]];
        }
        return $items;
    }

}
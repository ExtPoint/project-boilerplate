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
            '' => $this->id . '/site/index',
        ];
    }

}
<?php

namespace app\profile;

use app\core\base\AppModule;

class ProfileModule extends AppModule {

    public $layout = '@app/core/layouts/web';

    protected function coreUrlRules() {
        return [
            '' => $this->id . '/site/index',
        ];
    }

}
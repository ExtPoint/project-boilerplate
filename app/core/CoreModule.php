<?php

namespace app\core;

use app\core\base\WebApplication;
use app\core\base\AppModule;
use yii\helpers\FormatConverter;

class CoreModule extends AppModule {

    /**
     * @param WebApplication $app
     */
    public function bootstrap($app) {
        // Date settings
        FormatConverter::$phpFallbackDatePatterns['short']['date'] = 'n/j/Y';
        FormatConverter::$juiFallbackDatePatterns['short']['date'] = 'd/m/Y';

        parent::bootstrap($app);
    }

}
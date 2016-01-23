<?php

namespace app\core;

use app\core\base\AppModule;
use app\core\base\WebApplication;
use yii\helpers\FormatConverter;

class CoreModule extends AppModule {

    public $layout = '@app/core/layouts/web';

    /**
     * @param WebApplication $app
     */
    public function bootstrap($app) {
        // Date settings
        FormatConverter::$phpFallbackDatePatterns['short']['date'] = 'n/j/Y';
        FormatConverter::$juiFallbackDatePatterns['short']['date'] = 'd/m/Y';
    }

}
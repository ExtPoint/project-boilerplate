<?php

namespace app\core;

use app\core\base\WebApplication;
use app\core\base\AppModule;
use extpoint\megamenu\middleware\AccessMiddleware;
use extpoint\yii2\middleware\AjaxResponseMiddleware;
use yii\helpers\FormatConverter;
use yii\web\Application;

class CoreModule extends AppModule
{
    /**
     * @param WebApplication $app
     */
    public function bootstrap($app)
    {
        // Date settings
        FormatConverter::$phpFallbackDatePatterns['short']['date'] = 'n/j/Y';
        FormatConverter::$juiFallbackDatePatterns['short']['date'] = 'd/m/Y';

        if ($app instanceof Application) {
            AccessMiddleware::register($app);
            AjaxResponseMiddleware::register($app);
        }

        parent::bootstrap($app);
    }

}
<?php

namespace app\core;

use app\core\base\WebApplication;
use app\core\base\AppModule;
use yii\base\ActionEvent;
use yii\helpers\FormatConverter;
use yii\web\Application;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

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
            $app->on(Controller::EVENT_BEFORE_ACTION, [$this, 'onControllerBeforeAction']);
        }

        parent::bootstrap($app);
    }

    /**
     * @param ActionEvent $event
     */
    public function onControllerBeforeAction($event)
    {
        // Check access
        $item = \Yii::$app->megaMenu->getActiveItem();
        if (!$item || !$item->checkVisible($item->normalizedUrl)) {
            if (\Yii::$app->user->isGuest) {
                \Yii::$app->user->loginRequired();
            }
            // TODO Show 403?
            //\Yii::$app->response->redirect(\Yii::$app->homeUrl);
            $event->isValid = false;
        }
    }
}
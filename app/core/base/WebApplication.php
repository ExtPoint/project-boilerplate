<?php

namespace app\core\base;

use Yii;
use extpoint\megamenu\MegaMenu;
use yii\web\Application;

/**
 * Class WebApplication
 * @package app\core\base
 * @property \app\core\components\ContextUser $user
 * @property MegaMenu $megaMenu
 */
class WebApplication extends Application {

    /**
     * @inheritdoc
     */
    protected function bootstrap()
    {
        parent::bootstrap();

        $versionFilePath = __DIR__ . '/../../../version.txt';
        if (file_exists($versionFilePath)) {
            $this->version = trim(file_get_contents($versionFilePath));
        }

        Yii::setAlias('@static', $this->getRequest()->getBaseUrl() . '/static/' . $this->version);
    }

}
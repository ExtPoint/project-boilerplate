<?php

namespace app\core\assets;

use yii\helpers\Json;
use yii\web\AssetBundle;
use yii\web\View;

class FrontendAssetBundle extends AssetBundle
{
    public function registerAssetFiles($view)
    {
        $view->registerJs("APP_CONFIG = " . Json::encode([
                'locale' => [
                    'language' => \Yii::$app->language,
                ],
            ]) . ";", View::POS_HEAD);

        parent::registerAssetFiles($view);
    }
}

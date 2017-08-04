<?php

namespace app\core\assets;

use extpoint\yii2\Utils;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\AssetBundle;
use yii\web\View;

class FrontendAssetBundle extends AssetBundle
{
    public function registerAssetFiles($view)
    {
        $view->registerJs("APP_CONFIG = " . Json::encode([
                'locale' => [
                    'language' => \Yii::$app->language,
                    'backendTimeZone' => Utils::parseTimeZone(\Yii::$app->timeZone),
                ],
                'types' => [
                    'config' => \Yii::$app->types->frontendConfig,
                    'fetchUrl' => Url::to(['/site/api-form/fetch']),
                    'autoCompleteUrl' => Url::to(['/site/api-form/auto-complete']),
                ],
            ]) . ";", View::POS_HEAD);

        parent::registerAssetFiles($view);
    }
}

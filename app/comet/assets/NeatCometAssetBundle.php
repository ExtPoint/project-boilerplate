<?php
namespace app\comet\assets;

use app\comet\CometModule;
use yii\helpers\Json;
use yii\web\AssetBundle;
use yii\web\View;

class NeatCometAssetBundle extends AssetBundle {

    public function registerAssetFiles($view) {
        $clientConfig = [
            'application' => [
                'components' => [
                    'comet' => [
                        'serverUrl' => CometModule::getInstance()->client->cometUrl,
                    ],
                    'neat' => [
                        'engine' => [
                            'profilesDefinition' => CometModule::getInstance()->neat->server->getClientParams()
                        ],
                    ],
                ],
            ],
        ];

        $view->registerJs("JII_CONFIG = " . Json::encode($clientConfig) . ";", View::POS_HEAD);
        parent::registerAssetFiles($view);
    }
}

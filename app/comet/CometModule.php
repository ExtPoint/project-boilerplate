<?php

namespace app\comet;

use app\core\base\AppModule;
use yii\base\Event;
use yii\db\ActiveRecord;

// Load NeatComet package
define('NEAT_COMET_PATH', __DIR__ . '/../../node_modules/neatcomet');
require NEAT_COMET_PATH . '/src/autoload.php';
require NEAT_COMET_PATH . '/quick_start/legacy_comet_server/adapters/yii2/CometClient.php';

/**
 * Class CometModule
 * @package app\comet
 */
class CometModule extends AppModule {

    /**
     * @var \NeatComet\quickStart\legacyCometServer\CometClient
     */
    public $client;

    /**
     * @var \NeatComet\adapters\yii2\NeatCometComponent
     */
    public $neat;

    /**
     * @inheritdoc
     */
    public function bootstrap($app) {
        parent::bootstrap($app);

        // Subscribe on model changes
        Event::on(ActiveRecord::className(), ActiveRecord::EVENT_AFTER_INSERT, function($event) {
            CometModule::getInstance()->neat->server->broadcastEvent(
                get_class($event->sender), 'sendAdd',
                $event->sender->attributes
            );
        });
        Event::on(ActiveRecord::className(), ActiveRecord::EVENT_AFTER_UPDATE, function($event) {
            CometModule::getInstance()->neat->server->broadcastEvent(
                get_class($event->sender), 'sendUpdate',
                $event->sender->attributes, $event->changedAttributes + $event->sender->oldAttributes
            );
        });
        Event::on(ActiveRecord::className(), ActiveRecord::EVENT_AFTER_DELETE, function($event) {
            CometModule::getInstance()->neat->server->broadcastEvent(
                get_class($event->sender), 'sendRemove',
                $event->sender->attributes
            );
        });
    }

    /**
     * @return \NeatComet\quickStart\legacyCometServer\CometClient
     */
    public function getClient() {
        return $this->client;
    }

    protected function coreUrlRules() {
        return [
            'comet' => $this->id . '/comet/index',
            'comet/load' => $this->id . '/api/load',
        ];
    }

    protected function coreComponents() {
        return [
            'client' => [
                'class' => '\NeatComet\quickStart\legacyCometServer\CometClient',
                'cometUrl' => 'http://127.0.0.1:5210/comet',
                'cometHttpUrl' => 'http://127.0.0.1:5200/api',
            ],
            'neat' => [
                'class' => '\NeatComet\adapters\yii2\NeatCometComponent',
                'cometComponent' => [$this, 'getClient'],
                'configFileName' => __DIR__ . '/bindings.json',
                //'hasDynamicAttributes' => true,
            ],
        ];
    }

}
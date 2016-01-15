<?php

namespace app\core\behaviors;

use yii\base\Behavior;
use yii\db\BaseActiveRecord;
use yii\helpers\Json;

class JsonStringBehavior extends Behavior {

    public $map = [];

    /**
     * @inheritdoc
     */
    public function events() {
        return [
            BaseActiveRecord::EVENT_INIT => 'onFind',
            BaseActiveRecord::EVENT_AFTER_FIND => 'onFind',
            BaseActiveRecord::EVENT_BEFORE_INSERT => 'onUpdate',
            BaseActiveRecord::EVENT_BEFORE_UPDATE => 'onUpdate',
        ];
    }

    public function onFind() {
        foreach ($this->map as $dbKey => $modelKey) {
            if (empty($this->owner->$dbKey)) {
                $this->owner->$modelKey = [];
            } elseif (is_string($this->owner->$dbKey)) {
                $this->owner->$modelKey = Json::decode($this->owner->$dbKey);
            }
        }
    }

    public function onUpdate() {
        foreach ($this->map as $dbKey => $modelKey) {
            if (empty($this->owner->$modelKey)) {
                $this->owner->$dbKey = '';
            } elseif (is_array($this->owner->$modelKey) || is_object($this->owner->$modelKey)) {
                $this->owner->$dbKey = Json::encode($this->owner->$modelKey);
            }
        }
    }

}

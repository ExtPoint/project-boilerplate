<?php

namespace app\core\behaviors;

use yii\base\Behavior;
use yii\db\BaseActiveRecord;
use yii\helpers\Json;

class BirthdayBehavior extends Behavior {

    public $attribute = 'birthday';

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
        $this->owner->{$this->attribute} = !empty($this->owner->{$this->attribute}) ?
            date('d.m.Y', strtotime($this->owner->{$this->attribute})) :
            '';
    }

    public function onUpdate() {
        $this->owner->{$this->attribute} = !empty($this->owner->{$this->attribute}) ?
            date('Y-m-d H:i:s', strtotime($this->owner->{$this->attribute})) :
            '';
    }

}

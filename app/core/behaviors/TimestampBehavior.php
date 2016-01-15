<?php

namespace app\core\behaviors;

use yii\db\BaseActiveRecord;

class TimestampBehavior extends \yii\behaviors\TimestampBehavior {

    public $createdAtAttribute = 'createTime';

    public $updatedAtAttribute = 'updateTime';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (empty($this->attributes)) {
            if ($this->createdAtAttribute || $this->updatedAtAttribute) {
                $this->attributes[BaseActiveRecord::EVENT_BEFORE_INSERT] = [];
            }
            if ($this->createdAtAttribute) {
                $this->attributes[BaseActiveRecord::EVENT_BEFORE_INSERT][] = $this->createdAtAttribute;
            }
            if ($this->updatedAtAttribute) {
                $this->attributes[BaseActiveRecord::EVENT_BEFORE_INSERT][] = $this->updatedAtAttribute;
                $this->attributes[BaseActiveRecord::EVENT_BEFORE_UPDATE] = $this->updatedAtAttribute;
            }
        }
    }

    public function getValue($event) {
        return date('Y-m-d H:i:s');
    }

}

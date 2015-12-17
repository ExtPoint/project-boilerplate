<?php

namespace app\core\behaviors;

use yii\base\Behavior;
use yii\base\Exception;
use yii\db\BaseActiveRecord;

/**
 * @property \yii\db\BaseActiveRecord $owner
 */
class ArrayStringBehavior extends Behavior {

	public $map = [];
	public $separator = ',';

    /**
     * @param string $string
     * @param string $separator
     * @return array
     */
    public static function stringToArray($string, $separator = ',') {
        return preg_split('/\s*' . $separator . '\s*/', trim($string), -1, PREG_SPLIT_NO_EMPTY);
    }

    /**
     * @param array $arr
     * @param string $separator
     * @return string
     */
    public static function arrayToString(array $arr, $separator = ',') {
        return implode($separator, $arr);
    }

	/**
	 * @inheritdoc
	 */
	public function events() {
		return [
			BaseActiveRecord::EVENT_INIT => 'onFind',
			BaseActiveRecord::EVENT_AFTER_FIND => 'onFind',
			BaseActiveRecord::EVENT_BEFORE_VALIDATE => 'onValidate',
			BaseActiveRecord::EVENT_BEFORE_INSERT => 'onUpdate',
			BaseActiveRecord::EVENT_BEFORE_UPDATE => 'onUpdate',
		];
	}

	public function onFind() {
		foreach ($this->map as $dbKey => $modelKey) {
            $this->attributeToArray($dbKey, $modelKey);
		}
	}

    public function onValidate() {
        foreach ($this->map as $dbKey => $modelKey) {
            if ($this->owner->isAttributeChanged($dbKey)) {
                $this->attributeToArray($dbKey, $modelKey);
            } elseif ($this->owner->isAttributeChanged($modelKey)) {
                $this->attributeToString($dbKey, $modelKey);
            }
        }
    }

	public function onUpdate() {
		foreach ($this->map as $dbKey => $modelKey) {
            $this->attributeToString($dbKey, $modelKey);
		}
	}

    protected function attributeToArray($dbKey, $modelKey) {
        if ($this->owner->isNewRecord) {
            return;
        }

        if (empty($this->owner->$dbKey)) {
            $this->owner->$modelKey = [];
        } elseif (is_array($this->owner->$dbKey)) {
            $this->owner->$modelKey = $this->owner->$dbKey;
        } elseif (is_string($this->owner->$dbKey)) {
            $this->owner->$modelKey = self::stringToArray($this->owner->$dbKey, $this->separator);
        } else {
            throw new Exception('Wrong type: string or null value is expected.');
        }
    }

    protected function attributeToString($dbKey, $modelKey) {
        if (empty($this->owner->$modelKey)) {
            $this->owner->$dbKey = null;
        } elseif (is_array($this->owner->$modelKey) || is_object($this->owner->$modelKey)) {
            $this->owner->$dbKey = self::arrayToString($this->owner->$modelKey, $this->separator);
        } else {
            throw new Exception('Wrong type: array is expected.');
        }
    }
}

<?php

namespace app\core\behaviors;

use yii\behaviors\AttributeBehavior;
use yii\db\BaseActiveRecord;

/**
 * @property-read BaseActiveRecord $owner
 */

class UniqueStringBehavior extends AttributeBehavior {

	public $attribute;
	public $length = 8;
    public $characters = '0123456789abcdefghijklmnopqrstuvwxyz';

	public function generate() {
		$charactersLength = strlen($this->characters);
		$randomString = '';
		for ($i = 0; $i < $this->length; $i++) {
			$randomString .= $this->characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}

	/**
	 * @inheritdoc
	 */
	public function init() {
		parent::init();

		$this->attributes = [
			BaseActiveRecord::EVENT_INIT => $this->attribute,
		];
	}

	/**
	 * @inheritdoc
	 */
	protected function getValue($event) {
		do {
			$string = $this->generate();
		} while(
			$this->owner->find()
				->where([$this->attribute => $string])
				->exists()
		);
		return $string;
	}
}

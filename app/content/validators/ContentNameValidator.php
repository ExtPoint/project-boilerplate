<?php

namespace app\content\validators;

use Yii;
use yii\validators\Validator;

class ContentNameValidator extends Validator {

    public static $pattern = '[a-zA-Z0-9\/-]+';

    /**
     * @inheritdoc
     */
    public function init() {
        parent::init();
        if ($this->message === null) {
            $this->message = Yii::t('app', 'Неправильный формат поля {attribute}, имеются недопустимые символы.');
        }
    }

    /**
     * @inheritdoc
     */
    protected function validateValue($value) {
        if (is_string($value) && !preg_match('/' . static::$pattern . '/', $value)) {
            return [$this->message, []];
        }
        return null;
    }

}

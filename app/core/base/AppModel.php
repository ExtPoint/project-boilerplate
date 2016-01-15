<?php

namespace app\core\base;
use yii\base\Exception;

/**
 * @package app\core\base
 */
class AppModel extends \yii\db\ActiveRecord {

    public function saveOrPanic($runValidation = true, $attributeNames = null) {
        if (!$this->save($runValidation, $attributeNames)) {
            throw new Exception('Cannot save model `' . static::className() . '`: ' . var_export($this->getErrors(), true));
        }
    }

}
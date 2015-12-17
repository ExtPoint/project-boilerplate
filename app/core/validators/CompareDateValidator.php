<?php

namespace app\core\validators;

use yii\base\InvalidConfigException;
use yii\db\BaseActiveRecord;
use yii\validators\Validator;

class CompareDateValidator extends Validator {

    public $format = 'Y-m-d H:i:s';
    public $operator;
    public $compareAttribute;

    /**
     * @inheritdoc
     */
    public function init() {
        parent::init();

        if ($this->message === null) {
            $this->message = \Yii::t('app', 'Должно выполняться условие для `{attribute}`: {left} {operator} {right}');
        }

        if (empty($this->operator)) {
            throw new InvalidConfigException('Operator is required.');
        }
        if (empty($this->compareAttribute)) {
            throw new InvalidConfigException('Operator is required.');
        }
    }

    /**
     * @param BaseActiveRecord $model the data model to be validated
     * @param string $attribute the name of the attribute to be validated.
     * @throws \Exception
     */
    public function validateAttribute($model, $attribute) {
        $left = \DateTime::createFromFormat($this->format, $model->$attribute);
        $right = \DateTime::createFromFormat($this->format, $model->{$this->compareAttribute});

        switch ($this->operator) {
            case '<':
                $result = $left < $right;
                break;

            case '>':
                $result = $left > $right;
                break;

            case '==':
                $result = $left == $right;
                break;

            default:
                throw new \Exception('Unknown operator, only ">", "<" and "==" are supported.');
        }

        if (!$result) {
            $this->addError($model, $attribute, \Yii::$app->getI18n()->format($this->message, [
                'attribute' => $model->getAttributeLabel($attribute),
                'operator' => $this->operator,
                'left' => $left->format('Y-m-d H:i'),
                'right' => $right->format('Y-m-d H:i'),
            ], \Yii::$app->language));
        }
    }


}
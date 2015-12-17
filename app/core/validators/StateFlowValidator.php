<?php

namespace app\core\validators;

use yii\base\InvalidConfigException;
use yii\db\BaseActiveRecord;
use yii\validators\Validator;

class StateFlowValidator extends Validator {

    public $flow = [];
    public $advanced = [];

    /**
     * @var boolean this property is overwritten to be false so that this validator will
     * be applied when the value being validated is empty.
     */
    public $skipOnEmpty = false;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if ($this->message === null) {
            $this->message = \Yii::t('yii', '{attribute} should be switched only to state "{available}" from state "{from}". Try "{to}"');
        }

        if (empty($this->flow)) {
            throw new InvalidConfigException('Not found state flow, param `flow` is empty.');
        }
        if (!is_string($this->flow[0])) {
            throw new InvalidConfigException('First state can not be multiple.');
        }
    }

    /**
     * @param BaseActiveRecord $model the data model to be validated
     * @param string $attribute the name of the attribute to be validated.
     */
    public function validateAttribute($model, $attribute)
    {
        $from = $model->getOldAttribute($attribute);
        $to = $model->$attribute;

        if ($this->isEmpty($from)) {
            $model->$attribute = $this->flow[0];
        } elseif (!$this->isEmpty($from) && !$this->isEmpty($to) && $from !== $to) {
            $availableStates = $this->findNextAvailableStates($from);
            if (!in_array($to, $availableStates)) {
                // @todo find in advanced..

                $this->addError($model, $attribute, \Yii::$app->getI18n()->format($this->message, [
                    'attribute' => $model->getAttributeLabel($attribute),
                    'from' => $from,
                    'to' => $to,
                    'available' => implode(', ', $availableStates),
                ], \Yii::$app->language));
            }
        }
    }

    protected function findNextAvailableStates($state) {
        $returnNext = false;
        foreach ($this->flow as $states) {
            if (!is_array($states)) {
                $states = [$states];
            }
            if ($returnNext) {
                return $states;
            }

            if (in_array($state, $states)) {
                $returnNext = true;
            }
        }

        return [];
    }

}
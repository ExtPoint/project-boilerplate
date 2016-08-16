<?php

namespace app\core\widgets;

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

class AppActiveForm extends ActiveForm
{

    public $layout = 'horizontal';
    public $fieldClass = 'app\core\widgets\AppActiveField';

    /**
     * @inheritdoc
     * @return \app\core\widgets\AppActiveField the created ActiveField object
     */
    public function field($model, $attribute, $options = [])
    {
        return parent::field($model, $attribute, $options);
    }

    public function submitButton($label, $options = []) {
        $buttonStr = Html::submitButton($label, array_merge($options, ['class' => 'btn btn-primary']));
        if ($this->layout == 'horizontal') {
            return "<div class=\"form-group\"><div class=\"col-sm-offset-3 col-sm-6\">$buttonStr</div></div>";
        } else {
            return "<div class=\"form-group\">$buttonStr</div>";
        }
    }

    public function beginFieldset($title, $options = []) {
        $optionsStr = '';
        foreach ($options as $key => $value) {
            $optionsStr .= " $key=\"$value\"";
        }

        return "<fieldset $optionsStr><h3>$title</h3>";
    }

    public function endFieldset() {
        return "</fieldset>";
    }

}
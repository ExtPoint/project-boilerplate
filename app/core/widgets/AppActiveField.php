<?php

namespace app\core\widgets;

use app\dictionary\models\Dictionary;
use yii\bootstrap\ActiveField;
use app\file\widgets\fileup\FileInput;
use kartik\widgets\DatePicker;
use kartik\widgets\DateTimePicker;
use kartik\widgets\ColorInput;
use dosamigos\ckeditor\CKEditor;

class AppActiveField extends ActiveField
{

    public function email($options = []) {
        $this->template = '{label}<div class="input-group"><span class="input-group-addon">@</span>{input}</div>';
        return $this->textInput($options);
    }

    public function phone($options = []) {
        $this->template = '{label}<div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-phone"></span></span>{input}</div>';
        return $this->textInput($options);
    }

    public function dictionary($type, $options = []) {
        return $this->dropDownList(Dictionary::getLabels($type), $options);
    }

    public function file($options = []) {
        $this->parts['{input}'] = FileInput::widget([
            'model' => $this->model,
            'attribute' => $this->attribute,
            'options' => $options,
        ]);
        return $this;
    }

    public function date($options = []) {
        $this->parts['{input}'] = DatePicker::widget([
            'model' => $this->model,
            'attribute' => $this->attribute,
            'options' => $options,
        ]);
        return $this;
    }

    public function dateTime($options = []) {
        $this->parts['{input}'] = DateTimePicker::widget([
            'model' => $this->model,
            'attribute' => $this->attribute,
            'options' => $options,
        ]);
        return $this;
    }

    public function birthday($options = []) {
        return $this->date($options);
    }

    public function color($options = []) {
        $this->parts['{input}'] = ColorInput::widget([
            'model' => $this->model,
            'attribute' => $this->attribute,
            'options' => $options,
        ]);
        return $this;
    }

    public function enum($enumClassName, $options = []) {
        return $this->dropDownList($enumClassName::getLabels(), $options);
    }

    public function wysiwyg($options = []) {
        $this->parts['{input}'] = CKEditor::widget([
            'model' => $this->model,
            'attribute' => $this->attribute,
            'options' => $options,
        ]);
        return $this;
    }

}
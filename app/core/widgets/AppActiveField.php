<?php

namespace app\core\widgets;

use app\dictionary\models\Dictionary;
use app\file\widgets\FileInput\FileInput;
use yii\bootstrap\ActiveField;
use kartik\widgets\DatePicker;
use kartik\widgets\DateTimePicker;
use kartik\widgets\ColorInput;
use dosamigos\ckeditor\CKEditor;
use yii\helpers\ArrayHelper;

class AppActiveField extends ActiveField
{

    /**
     * @inheritdoc
     */
    public function textInput($options = []) {
        return parent::textInput($options);
    }

    /**
     * @inheritdoc
     */
    public function hiddenInput($options = []) {
        return parent::hiddenInput($options);
    }

    /**
     * @inheritdoc
     */
    public function passwordInput($options = []) {
        return parent::passwordInput($options);
    }

    /**
     * @inheritdoc
     */
    public function fileInput($options = []) {
        return parent::fileInput($options);
    }

    /**
     * @inheritdoc
     */
    public function textarea($options = []) {
        return parent::textarea($options);
    }

    /**
     * @inheritdoc
     */
    public function checkbox($options = [], $enclosedByLabel = true) {
        return parent::checkbox($options, $enclosedByLabel);
    }

    /**
     * @inheritdoc
     */
    public function radio($options = [], $enclosedByLabel = true) {
        return parent::radio($options, $enclosedByLabel);
    }

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
        $this->parts['{input}'] = FileInput::widget(ArrayHelper::merge(
            [
                'model' => $this->model,
                'attribute' => $this->attribute,
            ],
            $options
        ));
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
            'clientOptions' => [
                'toolbarGroups' => [
                    ['name' => 'styles'],
                    ['name' => 'clipboard', 'groups' => ['clipboard', 'undo']],
                    ['name' => 'document', 'groups' => ['mode']],
                    ['name' => 'links'],
                    ['name' => 'forms'],
                    ['name' => 'tools'],
                    ['name' => 'tools'],
                    '/',
                    ['name' => 'basicstyles', 'groups' => ['basicstyles', 'colors','cleanup']],
                    ['name' => 'paragraph', 'groups' => [ 'list', 'indent', 'blocks', 'align', 'bidi' ]],
                    ['name' => 'insert'],
                ],
                'removeButtons' => 'Form,Checkbox,Radio,TextField,Textarea,Select,Button,HiddenField',
                'extraPlugins' => 'filebrowser',
                'filebrowserUploadUrl' => '/file/upload/editor/'
            ],
            'preset' => 'custom',
        ]);
        return $this;
    }

}
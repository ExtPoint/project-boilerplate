<?php

namespace app\core\widgets;

use extpoint\yii2\widgets\ActiveForm;

class AppActiveForm extends ActiveForm
{
    public $fieldClass = 'app\core\widgets\AppActiveField';
}
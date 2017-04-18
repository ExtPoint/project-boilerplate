<?php

namespace app\core\widgets;

use app\core\base\AppModel;
use extpoint\yii2\base\Model;
use yii\bootstrap\ActiveField;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;

class AppActiveForm extends ActiveForm
{

    public $layout = 'horizontal';

    /**
     * @param Model $model
     * @param string $attribute
     * @param array $options
     * @return ActiveField
     */
    public function field($model, $attribute, $options = [])
    {
        $prevLayout = $this->layout;
        $layout = ArrayHelper::remove($options, 'layout');
        if ($layout) {
            $this->layout = $layout;
        }
        /** @var ActiveField $result */
        $result = parent::field($model, $attribute, $options);
        if ($layout) {
            $this->layout = $prevLayout;
        }

        // Render field by type
        if ($model instanceof Model) {
            $item = $model::meta()[Html::getAttributeName($attribute)];
            $appType = \Yii::$app->types->getType(!empty($item['appType']) ? $item['appType'] : 'string');
            $appType->renderField($result, $item, $options);
        }

        return $result;
    }

    /**
     * @param string $label
     * @param array $options
     * @return string
     */
    public function submitButton($label, $options = []) {
        $buttonStr = Html::submitButton($label, array_merge($options, ['class' => 'btn btn-primary']));
        if ($this->layout == 'horizontal') {
            return "<div class=\"form-group\"><div class=\"col-sm-offset-3 col-sm-6\">$buttonStr</div></div>";
        } else {
            return "<div class=\"form-group\">$buttonStr</div>";
        }
    }

    /**
     * @param AppModel $model
     */
    public function fields($model) {
        foreach ($model::meta() as $attribute => $item) {
            if (!empty($item['showInForm'])) {
                echo $this->field($model, $attribute);
            }
        }
    }

    /**
     * @param AppModel $model
     * @param array $buttons
     * @return string
     */
    public function controls($model, $buttons = []) {
        $defaultButtons = [
            'submit' => [
                'label' => $model->isNewRecord ? 'Добавить' : 'Сохранить',
                'order' => 0,
            ],
            'cancel' => [
                'label' => 'Назад',
                'url' => ['index'],
                'order' => 10,
            ],
        ];
        $buttons = array_merge($defaultButtons, $buttons);
        ArrayHelper::multisort($buttons, 'order');

        $buttonHtmls = [];
        foreach ($buttons as $id => $button) {
            if (!$button) {
                continue;
            }

            if (isset($defaultButtons[$id])) {
                $button = array_merge($defaultButtons[$id], $button);
            }

            ArrayHelper::remove($button, 'order');
            $label = ArrayHelper::remove($button, 'label');
            $url = ArrayHelper::remove($button, 'url');

            if ($id === 'submit') {
                $buttonHtmls[] = Html::submitButton($label, array_merge(['class' => 'btn btn-primary'], $button));
            } else {
                $buttonHtmls[] = Html::a($label, $url, array_merge(['class' => 'btn btn-default'], $button));
            }
        }

        $html = implode(' ', $buttonHtmls);
        if ($this->layout == 'horizontal') {
            return "<div class=\"form-group\"><div class=\"col-sm-offset-3 col-sm-6\">$html</div></div>";
        } else {
            return "<div class=\"form-group\">$html</div>";
        }
    }

    public function beginFieldset($title, $options = []) {
        $optionsStr = '';
        foreach ($options as $key => $value) {
            $optionsStr .= " $key=\"$value\"";
        }

        return "<fieldset $optionsStr><div class=\"form-group\"><div class=\"col-sm-offset-3 col-sm-6\"><b>$title</b></div></div><div style=\"margin-left: 30px\">";
    }

    public function endFieldset() {
        return "</div></fieldset>";
    }

}
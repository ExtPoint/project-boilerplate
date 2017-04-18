<?php

namespace app\core\widgets;

use extpoint\yii2\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

class AppDetailView extends DetailView
{
    protected function renderAttribute($attribute, $index)
    {
        if (is_string($this->template)) {
            $captionOptions = Html::renderTagAttributes(ArrayHelper::getValue($attribute, 'captionOptions', []));
            $contentOptions = Html::renderTagAttributes(ArrayHelper::getValue($attribute, 'contentOptions', []));
            return strtr($this->template, [
                '{label}' => $attribute['label'],
                '{value}' => $this->renderValue($attribute, $index),
                '{captionOptions}' => $captionOptions,
                '{contentOptions}' =>  $contentOptions,
            ]);
        } else {
            return call_user_func($this->template, $attribute, $index, $this);
        }
    }

    protected function normalizeAttributes()
    {
        if ($this->model instanceof Model && $this->attributes === null) {
            $modelClass = $this->model;
            $this->attributes = array_keys(array_filter($modelClass::meta(), function($item) {
                return !empty($item['showInView']);
            }));
        }
        parent::normalizeAttributes();
    }

    protected function renderValue($attribute, $index) {
        if (isset($attribute['attribute']) && $this->model instanceof Model) {
            $modelClass = $this->model;
            $meta = $modelClass::meta();
            if (isset($meta[$attribute['attribute']])) {
                $item = $meta[$attribute['attribute']];
                $options = ArrayHelper::getValue($attribute, 'options', []);
                $appType = \Yii::$app->types->getType(isset($item['appType']) ? $item['appType'] : 'string');
                return $appType->renderForView($this->model, $attribute['attribute'], $item, $options);
            }
        }

        return $this->formatter->format($attribute['value'], $attribute['format']);
    }
}
<?php

namespace app\core\widgets;

use yii\bootstrap\Html;
use yii\widgets\InputWidget;

class TreeDropdownWidget extends InputWidget
{
    public $displayField = 'title';

    public $currentItem;

    public $options = [];

    protected $disabledItems = [];

    public function run()
    {
        $items = $this->getItems();

        $options = array_merge(
            [
                'class' => 'form-control',
                'encodeSpaces' => true,
                'prompt' => '---Не выбрана---',
                'options' => $this->disabledItems,
            ],
            $this->options
        );

        return Html::activeDropDownList($this->model, $this->attribute, $items, $options);
    }

    protected function createTree($models, $array = [], $parentUid = null) {
        foreach ($models as $key => $model) {
            if ($model->{$this->attribute} == $parentUid) {
                $array[$model->primaryKey] = ['value' => $model->title, 'items' => []];
                unset($models[$key]);
            }
        }

        foreach ($array as $key => $item) {
            $array[$key]['items'] = self::createTree($models, $item['items'], $key);
        }

        return $array;
    }

    protected function treeToItems($array, $level = 0, $disabled = false) {
        $result = [];

        foreach($array as $key => $value) {
            $disableChildren = false;
            if (($key == $this->currentItem) || $disabled) {
                $this->disabledItems[$key] = ['disabled' => true];
                $disableChildren = true;
            }

            $items = self::treeToItems($value['items'], $level + 1, $disableChildren);

            $result = array_merge(
                $result,
                [$key => ($level > 0 ? str_repeat('   ', $level - 1) . '---' : '') . $value['value']],
                $items
            );
        }

        return $result;
    }

    protected function getItems() {
        $model = $this->model;
        $models = $model::find()->all();
        $tree = $this->createTree($models);
        return $this->treeToItems($tree);
    }
}
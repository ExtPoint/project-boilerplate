<?php

namespace app\core\components\widgets;

use yii\bootstrap\Html;
use yii\base\Widget;

class TreeDropdownWidget extends Widget
{
    public $model;

    public $attribute = 'parentUid';

    public $idField = 'uid';

    public $displayField = 'title';

    public $options = [];

    public function run()
    {
        $options = array_merge(
            $this->options,
            [
                'class' => 'form-control',
                'encodeSpaces' => true,
            ]
        );
        return Html::activeDropDownList($this->model, $this->attribute, $this->getItems(), $options);
    }

    public static function addItemToTree($array, $parentUid, $itemUid, $itemValue) {
        if (!$parentUid) {
            $array[$itemUid] = ['value' => $itemValue, 'items' => []];
        } elseif (array_key_exists($parentUid, $array)) {
            $array[$parentUid]['items'][$itemUid] = ['value' => $itemValue, 'items' => []];
        } else {
            foreach($array as $key => $value) {
                $array[$key]['items'] = self::addItemToTree($value['items'], $parentUid, $itemUid, $itemValue);
            }
        }
        return $array;
    }

    public static function treeToItems($array, $tab = '') {
        $result = [];
        foreach($array as $key => $value) {
            $items = self::treeToItems($value['items'], $tab . '    ');
            $result = array_merge(
                $result,
                [$key => $tab . $value['value']],
                $items
            );
        }
        return $result;
    }

    public function getItems() {
        $model = $this->model;
        $models = $model::find()->orderBy('createTime')->all();
        $tree = [];
        foreach ($models as $itemModel) {
            $parentUid = $itemModel->{$this->attribute};
            $itemUid = $itemModel->{$this->idField};
            $itemValue = $itemModel->{$this->displayField};
            $tree = self::addItemToTree($tree, $parentUid, $itemUid, $itemValue);
        }
        return self::treeToItems($tree);
    }
}
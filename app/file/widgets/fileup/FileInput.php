<?php

namespace app\file\widgets\fileup;

use app\file\models\File;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use yii\widgets\InputWidget;

class FileInput extends InputWidget {

    public $url = ['/file/upload/index'];
    public $multiple = false;
    public $options = [];

    public function init() {
        $id = $this->getId();
        $options = Json::htmlEncode(ArrayHelper::merge($this->options, [
            'uploader' => [
                'backendUrl' => Url::to($this->url)
            ],
            'files' => $this->getFiles(),
            'multiple' => $this->multiple,
        ]));
        $this->getView()->registerJs("jQuery('#$id').fileInput($options)");

        echo Html::activeHiddenInput($this->model, $this->attribute, [
            'id' => $id,
        ]);
    }

    protected function getFiles() {
        $value = $this->model{$this->attribute} ?: [];
        if (empty($value)) {
            return [];
        }

        if (is_string($value)) {
            $value = StringHelper::explode($value);
        }

        $value = $this->multiple ? $value : [$value[0]];
        return array_map(function($fileModel) {
            /** @var File $fileModel */
            return $fileModel->getExtendedAttributes();
        }, File::findAll($value));
    }

}
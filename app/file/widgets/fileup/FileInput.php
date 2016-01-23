<?php

namespace app\file\widgets\fileup;

use app\file\models\File;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
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
        ]));
        $this->getView()->registerJs("jQuery('#$id').fileInput($options)");

        echo Html::activeHiddenInput($this->model, $this->attribute, [
            'id' => $id,
        ]);
    }

    protected function getFiles() {
        $value = $this->model{$this->attribute};

        // @todo multiple

        if ($value && is_string($value)) {
            /** @var File $fileModel */
            $fileModel = File::findOne($value);
            if ($fileModel) {
                return [
                    $fileModel->getExtendedAttributes(),
                ];
            }
        }

        return [];
    }

}
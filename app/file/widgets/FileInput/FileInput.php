<?php

namespace app\file\widgets\FileInput;

use app\core\base\AppWidget;
use app\file\models\File;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;

class FileInput extends AppWidget
{
    public $url = ['/file/upload/index'];
    public $multiple = false;
    public $options = [];
    public $model;
    public $attribute;

    /**
     * Renders the widget.
     */
    public function run()
    {
        return $this->renderReact([
            'multiple' => $this->multiple,
            'name' => Html::getInputName($this->model, $this->attribute),
            'backendUrl' => Url::to($this->url),
            'initialFiles' => $this->getFiles(),
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

            return [
                'uid' => $fileModel->uid,
                'path' => $fileModel->title,
                'type' => $fileModel->fileMimeType,
                'bytesUploaded' => $fileModel->fileSize,
                'bytesUploadEnd' => $fileModel->fileSize,
                'bytesTotal' => $fileModel->fileSize,
                'resultHttpMessage' => $fileModel->getExtendedAttributes(),
            ];
        }, File::findAll($value));
    }

}
<?php

namespace app\content\models;

use Yii;

class ContentNews extends Content {

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['category', 'previewText', 'image'], 'string', 'max' => 255],
        ]);
    }

}

<?php

namespace app\content\models;

use app\content\enums\ContentType;
use Yii;

class ContentPage extends Content {

    public function attributes() {
        return array_diff(parent::attributes(), [
            'category',
            'previewText',
            'image',
        ]);
    }

}

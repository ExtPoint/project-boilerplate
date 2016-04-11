<?php

namespace app\content\models;

use app\content\enums\ContentType;
use Yii;

class ContentText extends Content {

    public function attributes() {
        return array_diff(parent::attributes(), [
            'category',
            'previewText',
        ]);
    }

    public static function getText($name) {
        $model = self::findOne([
            'type' => ContentType::TEXT,
            'name' => $name,
        ]);
        return $model && $model->isPublished ? $model->text : '';
    }

}

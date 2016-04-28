<?php

namespace app\content\models;

use app\content\enums\ContentType;
use Yii;

/**
 * @property string $metaKeywords
 * @property string $metaDescription
 */
class Page extends BaseContent {

    public static function tableName() {
        return 'pages';
    }

}

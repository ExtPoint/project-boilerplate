<?php

namespace app\content\enums;

use app\content\models\Article;
use extpoint\yii2\base\Enum;

class ContentType extends Enum {

    const NEWS = 'news';
    const ARTICLE = 'article';

    public static function getLabels() {
        return [
            self::NEWS => 'Новости',
            self::ARTICLE => 'Статьи',
        ];
    }

    public static function getClassName($id) {
        $map = [
            self::NEWS => Article::className(),
            self::ARTICLE => Article::className(),
        ];
        return isset($map[$id]) ? $map[$id] : null;
    }

}
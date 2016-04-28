<?php

namespace app\content\enums;

use app\content\models\Content;
use app\content\models\Page;
use app\content\models\TextSection;
use extpoint\yii2\base\Enum;

class ContentType extends Enum {

    const NEWS = 'news';
    const ARTICLE = 'article';
    const PAGE = 'page';
    const TEXT = 'text';

    public static function getLabels() {
        return [
            self::NEWS => 'Новости',
            self::ARTICLE => 'Статьи',
            self::PAGE => 'Страницы',
            self::TEXT => 'Тексты',
        ];
    }

    public static function getClassName($id) {
        $map = [
            self::TEXT => TextSection::className(),
            self::PAGE => Page::className(),
            self::NEWS => Content::className(),
        ];
        return isset($map[$id]) ? $map[$id] : null;
    }

}
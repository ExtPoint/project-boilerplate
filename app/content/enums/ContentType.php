<?php

namespace app\content\enums;

use app\content\models\ContentPage;
use app\content\models\ContentText;
use extpoint\yii2\base\AppEnum;

class ContentType extends AppEnum {

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
            self::TEXT => ContentText::className(),
            self::PAGE => ContentPage::className(),
        ];
        return isset($map[$id]) ? $map[$id] : null;
    }

}
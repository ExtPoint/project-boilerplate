<?php

namespace app\content\enums;

use extpoint\yii2\base\AppEnum;

class ContentCategory extends AppEnum {

    const ON_START_PAGE = 'on_start_page';

    public static function getLabels() {
        return [
            self::ON_START_PAGE => 'На главной',
        ];
    }

}
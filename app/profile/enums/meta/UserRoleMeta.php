<?php

namespace app\profile\enums\meta;

use extpoint\yii2\base\Enum;

abstract class UserRoleMeta extends Enum
{
    const USER = 'user';
    const ADMIN = 'admin';

    public static function getLabels()
    {
        return [
            'user' => 'Пользователь',
            'admin' => 'Администратор'
        ];
    }
}

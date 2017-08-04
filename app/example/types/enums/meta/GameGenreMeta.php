<?php

namespace app\example\types\enums\meta;

use extpoint\yii2\base\Enum;

abstract class GameGenreMeta extends Enum
{
    const ACTION = 1;
    const SIMULATOR = 4;
    const STRATEGY = 6;
    const ADVENTURE = 55;
    const ROLE_PLAYING = 62;

    public static function getLabels()
    {
        return [
            1 => '3D-экшен',
            4 => 'Симулятор "a" \'b\'',
            6 => 'Стратегия',
            55 => 'Приключения',
            62 => 'Ролевая'
        ];
    }

    public static function getCssClasses()
    {
        return [
            1 => 'success',
            4 => 'warning',
            6 => 'warning',
            62 => 'info'
        ];
    }

    public static function getEeData()
    {
        return [
            1 => '352436r',
            4 => 'ty',
            6 => 'ryt',
            55 => '',
            62 => 'rrr'
        ];
    }

    public static function getEe($id)
    {
        return isset($data[$id]) ? $data[$id] : null;
    }
}

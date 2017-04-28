<?php

namespace app\example\types\enums\meta;

use extpoint\yii2\base\Enum;

abstract class GameGenreMeta extends Enum
{
    const ACTION = 'action';
    const SIMULATOR = 'simulator';
    const STRATEGY = 'strategy';
    const ADVENTURE = 'adventure';
    const ROLE_PLAYING = 'role_playing';

    public static function getLabels()
    {
        return [
            'action' => '3D-экшен',
            'simulator' => 'Симулятор',
            'strategy' => 'Стратегия',
            'adventure' => 'Приключения',
            'role_playing' => 'Ролевая'
        ];
    }
}

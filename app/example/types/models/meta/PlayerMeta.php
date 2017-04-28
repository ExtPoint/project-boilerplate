<?php

namespace app\example\types\models\meta;

use app\core\base\AppModel;
use app\profile\enums\UserRole;

/**
 * @property string $id
 * @property string $name
 * @property string $email
 * @property string $role
 */
abstract class PlayerMeta extends AppModel
{
    public static function tableName()
    {
        return 'example_types_players';
    }

    public function rules()
    {
        return [
            [['name', 'email'], 'required'],
            [['name', 'email', 'role'], 'string'],
        ];
    }

    public static function meta()
    {
        return [
            'id' => [
                'label' => 'ID',
                'appType' => 'primaryKey'
            ],
            'name' => [
                'label' => 'Имя',
                'required' => true,
                'showInForm' => true,
                'showInTable' => true,
                'showInView' => true
            ],
            'email' => [
                'label' => 'Email',
                'required' => true,
                'showInForm' => true,
                'showInTable' => true,
                'showInView' => true,
                'stringType' => 'email'
            ],
            'role' => [
                'label' => 'Роль',
                'appType' => 'enum',
                'showInForm' => true,
                'showInView' => true,
                'enumClassName' => UserRole::className()
            ]
        ];
    }
}

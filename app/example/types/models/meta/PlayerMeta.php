<?php

namespace app\example\types\models\meta;

use app\core\base\AppModel;
use extpoint\yii2\validators\WordsValidator;
use app\profile\enums\UserRole;

/**
 * @property string $id
 * @property string $name
 * @property string $role
 * @property string $email
 */
abstract class PlayerMeta extends AppModel
{
    public static function tableName()
    {
        return 'example_types_players';
    }

    public function fields()
    {
        return [
        ];
    }

    public function rules()
    {
        return [
            [['name', 'email'], 'string', 'max' => 255],
            [['name', 'name', 'email', 'email'], 'required'],
            ['name', WordsValidator::className()],
            ['role', 'in', 'range' => UserRole::getKeys()],
            ['email', 'email'],
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
                'showInView' => true,
                'stringType' => 'words'
            ],
            'role' => [
                'label' => 'Роль',
                'appType' => 'enum',
                'showInForm' => true,
                'showInView' => true,
                'enumClassName' => UserRole::className()
            ],
            'email' => [
                'label' => 'Email',
                'appType' => 'email',
                'required' => true
            ]
        ];
    }
}

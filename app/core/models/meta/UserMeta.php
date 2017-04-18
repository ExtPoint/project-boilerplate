<?php

namespace app\core\models\meta;

use app\core\base\AppModel;
use yii\db\ActiveQuery;
use extpoint\yii2\file\models\File;

/**
 * @property string $id
 * @property string $email
 * @property string $name
 * @property string $role
 * @property string $photo
 * @property string $password
 * @property string $salt
 * @property string $authKey
 * @property string $accessToken
 * @property string $recoveryKey
 * @property string $createTime
 * @property string $updateTime
 * @property string $firstName
 * @property string $lastName
 * @property string $birthday
 * @property string $phone
 * @property-read File $photo
 */
abstract class UserMeta extends AppModel
{
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @return ActiveQuery
     */
    public function getPhoto()
    {
        return $this->hasOne(File::className(), ['id' => 'photo']);
    }

    public static function meta()
    {
        return [
            'id' => [
                'label' => 'Id',
                'dbType' => 'pk',
                'notNull' => 'true',
                'showInTable' => 'true',
                'showInView' => 'true'
            ],
            'email' => [
                'label' => 'Email',
                'notNull' => 'true',
                'showInForm' => 'true',
                'showInTable' => 'true',
                'showInView' => 'true'
            ],
            'name' => [
                'label' => 'Имя',
                'showInForm' => 'true',
                'showInTable' => 'true',
                'showInView' => 'true'
            ],
            'role' => [
                'label' => 'Роль',
                'notNull' => 'true',
                'showInForm' => 'true',
                'showInTable' => 'true',
                'showInView' => 'true'
            ],
            'photo' => [
                'label' => 'Фото'
            ],
            'password' => [
                'label' => 'Пароль'
            ],
            'salt' => [
                'label' => 'Salt'
            ],
            'authKey' => [
                'label' => 'Auth Key'
            ],
            'accessToken' => [
                'label' => 'Access Token'
            ],
            'recoveryKey' => [
                'label' => 'Recovery Key'
            ],
            'createTime' => [
                'label' => 'Дата регистрации',
                'dbType' => 'datetime',
                'notNull' => 'true',
                'showInTable' => 'true',
                'showInView' => 'true'
            ],
            'updateTime' => [
                'label' => 'Update Time',
                'dbType' => 'datetime',
                'notNull' => 'true'
            ],
            'firstName' => [
                'label' => 'Имя',
                'showInForm' => 'true',
                'showInView' => 'true'
            ],
            'lastName' => [
                'label' => 'Фамилия',
                'showInForm' => 'true',
                'showInView' => 'true'
            ],
            'birthday' => [
                'label' => 'Дата рождения',
                'dbType' => 'date',
                'showInForm' => 'true',
                'showInView' => 'true'
            ],
            'phone' => [
                'label' => 'Телефон',
                'showInForm' => 'true',
                'showInView' => 'true'
            ]
        ];
    }
}

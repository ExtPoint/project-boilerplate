<?php

namespace app\core\models\meta;

use app\core\base\AppModel;
use extpoint\yii2\file\models\File;
use yii\db\ActiveQuery;

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

    public function fields()
    {
        return [
        ];
    }

    public function rules()
    {
        return [
            [['id', 'email', 'name', 'role', 'photo', 'password', 'salt', 'authKey', 'accessToken', 'recoveryKey', 'createTime', 'updateTime', 'firstName', 'lastName', 'birthday', 'phone'], 'string', 'max' => 255],
            ['photo', 'exist', 'skipOnError' => true, 'targetClass' => File::className(), 'targetAttribute' => ['photo' => 'id']],
        ];
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
                'showInTable' => true,
                'showInView' => true,
                'dbType' => 'pk',
                'notNull' => true
            ],
            'email' => [
                'label' => 'Email',
                'showInForm' => true,
                'showInTable' => true,
                'showInView' => true,
                'notNull' => true
            ],
            'name' => [
                'label' => 'Имя',
                'showInForm' => true,
                'showInTable' => true,
                'showInView' => true
            ],
            'role' => [
                'label' => 'Роль',
                'showInForm' => true,
                'showInTable' => true,
                'showInView' => true,
                'notNull' => true
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
                'showInTable' => true,
                'showInView' => true,
                'dbType' => 'datetime',
                'notNull' => true
            ],
            'updateTime' => [
                'label' => 'Update Time',
                'dbType' => 'datetime',
                'notNull' => true
            ],
            'firstName' => [
                'label' => 'Имя',
                'showInForm' => true,
                'showInView' => true
            ],
            'lastName' => [
                'label' => 'Фамилия',
                'showInForm' => true,
                'showInView' => true
            ],
            'birthday' => [
                'label' => 'Дата рождения',
                'showInForm' => true,
                'showInView' => true,
                'dbType' => 'date'
            ],
            'phone' => [
                'label' => 'Телефон',
                'showInForm' => true,
                'showInView' => true
            ]
        ];
    }
}

<?php

namespace app\core\models\meta;

use app\core\base\AppModel;
use yii\db\ActiveQuery;
use app\core\models\User;

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
 * @property-read User $avatar
 * @property-read User $photos
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
    public function getAvatar()
    {
        return $this->hasOne(User::className(), ['uid' => 'photo']);
    }

    /**
     * @return ActiveQuery
     */
    public function getPhotos()
    {
        return $this->hasMany(User::className(), ['id' => 'userId'])
            ->viaTable('user_photos', ['fileId' => 'id']);
    }

    public static function meta()
    {
        return [
            'id' => [
                'label' => 'Id',
                'dbType' => 'pk',
                'notNull' => 'true'
            ],
            'email' => [
                'label' => 'Email',
                'notNull' => 'true',
                'fieldWidget' => 'email'
            ],
            'name' => [
                'label' => 'Имя'
            ],
            'role' => [
                'label' => 'Роль',
                'notNull' => 'true'
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
                'notNull' => 'true'
            ],
            'updateTime' => [
                'label' => 'Update Time',
                'dbType' => 'datetime',
                'notNull' => 'true'
            ],
            'firstName' => [
                'label' => 'Имя'
            ],
            'lastName' => [
                'label' => 'Фамилия'
            ],
            'birthday' => [
                'label' => 'Дата рождения',
                'dbType' => 'date'
            ],
            'phone' => [
                'label' => 'Телефон'
            ]
        ];
    }
}

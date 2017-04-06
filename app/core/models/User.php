<?php

namespace app\core\models;

use app\core\models\meta\UserMeta;
use extpoint\yii2\behaviors\BirthdayBehavior;
use extpoint\yii2\behaviors\TimestampBehavior;
use app\profile\enums\UserRole;
use extpoint\yii2\validators\PhoneValidator;
use yii\validators\DateValidator;
use yii\web\IdentityInterface;

class User extends UserMeta implements IdentityInterface {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            TimestampBehavior::className(),
            BirthdayBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['email', 'name', 'photo'], 'string', 'max' => 255],
            ['email', 'unique'],
            [['role', 'password', 'authKey', 'accessToken', 'recoveryKey'], 'string', 'max' => 32],
            ['salt', 'string', 'max' => 10],
            [['firstName', 'lastName'], 'string', 'max' => 255],
            ['birthday', DateValidator::className(), 'format' => 'dd.MM.yyyy'],
            ['phone', PhoneValidator::className()],
        ];
    }

    public function passwordToHash($value) {
        $this->salt = $this->salt ?: substr(md5(mt_rand() . time()), 0, 10);
        return md5(md5($value) . md5($this->salt));
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id) {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        return static::find()->where(['accessToken' => $token])->one();
    }

    /**
     * @param string $login
     * @return static|null
     */
    public static function findByLogin($login) {
        return static::find()->where(['email' => $login])->one();
    }

    /**
     * @inheritdoc
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey() {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey) {
        return $this->authKey === $authKey;
    }

    /**
     * @param string $password
     * @return boolean
     */
    public function validatePassword($password) {
        return md5(md5($password) . md5($this->salt)) === $this->password;
    }

    public function getPhotoUrl() {
        return ''; // @todo
    }

    public function canViewAttribute($userModel, $attribute) {
        return $userModel->id === $this->id || $this->role === UserRole::ADMIN;
    }

}

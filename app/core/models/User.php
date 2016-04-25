<?php

namespace app\core\models;

use app\core\base\AppModel;
use extpoint\yii2\behaviors\TimestampBehavior;
use extpoint\yii2\behaviors\UidBehavior;
use app\profile\enums\UserRole;
use app\profile\models\UserInfo;
use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property string $uid
 * @property string $email
 * @property string $name
 * @property string $role
 * @property string $password
 * @property string $salt
 * @property string $authKey
 * @property string $accessToken
 * @property string $recoveryKey
 * @property string $photo
 * @property string $createTime
 * @property string $updateTime
 * @property-read UserInfo $info
 * @property-read string $photoUrl
 */
class User extends AppModel implements IdentityInterface {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            UidBehavior::className(),
            TimestampBehavior::className(),
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
            [['salt'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'email' => Yii::t('app', 'Email'),
            'name' => Yii::t('app', 'Имя'),
            'role' => Yii::t('app', 'Роль'),
            'password' => Yii::t('app', 'Пароль'),
            'createTime' => Yii::t('app', 'Дата регистрации'),
            'photo' => Yii::t('app', 'Фото'),
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
        return $this->uid;
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

    public function getInfo() {
        return $this->hasOne(UserInfo::className(), ['userUid' => 'uid']);
    }

    public function getPhotoUrl() {
        return ''; // @todo
    }

    public function canViewAttribute($userModel, $attribute) {
        return $userModel->uid === $this->uid || $this->role === UserRole::ADMIN;
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes) {
        if ($insert && !$this->info) {
            $info = new UserInfo(['userUid' => $this->uid, 'firstName' => $this->name]);
            $info->userUid = $this->uid;
            $info->firstName = $this->name;
            $info->saveOrPanic();
        }

        parent::afterSave($insert, $changedAttributes);
    }

}

<?php

namespace app\profile\models;

use app\core\base\AppModel;
use extpoint\yii2\behaviors\BirthdayBehavior;
use app\core\models\User;
use extpoint\yii2\validators\PhoneValidator;
use app\profile\enums\UserRole;
use Yii;
use yii\validators\DateValidator;

/**
 * This is the model class for table "user_info".
 *
 * @property integer $userId
 * @property string $firstName
 * @property string $lastName
 * @property string $birthday
 * @property string $phone
 * @property-read User $user
 */
class UserInfo extends AppModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users_info';
    }

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            BirthdayBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userId'], 'integer'],
            [['firstName', 'lastName'], 'string', 'max' => 255],
            ['birthday', DateValidator::className(), 'format' => 'dd.MM.yyyy'],
            ['phone', PhoneValidator::className()],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'firstName' => Yii::t('app', 'Имя'),
            'lastName' => Yii::t('app', 'Фамилия'),
            'birthday' => Yii::t('app', 'Дата рождения'),
            'phone' => Yii::t('app', 'Телефон'),
        ];
    }

    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'userId']);
    }

    public function canViewAttribute($userModel, $attribute) {
        return $userModel->id === $this->userId || $this->user->role === UserRole::ADMIN;
    }
}

<?php

namespace app\profile\forms;

use app\core\models\User;
use Yii;
use yii\base\Model;

/**
 * @property User $_user
 */
class PasswordUpdate extends Model {

    public $oldPassword;
    public $password;
    public $passwordAgain;

    /** @var User */
    public $user = null;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['oldPassword', 'password', 'passwordAgain'], 'required'],
            [['passwordAgain'], 'compare', 'compareAttribute' => 'password'],
            [['oldPassword'], 'validateOldPassword'],
        ];
    }

    public function validateOldPassword($attribute, $params) {
        if (!$this->user->validatePassword($this->$attribute)) {
            $this->addError($attribute, 'Неверный текущий пароль.');
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'oldPassword' => 'Текущий пароль',
            'password' => 'Новый пароль',
            'passwordAgain' => 'Пароль еще раз',
        ];
    }

    /**
     * @return bool
     */
    public function change() {
        if (!$this->validate()) {
            return false;
        }

        $this->user->password = $this->user->passwordToHash($this->password);
        return $this->user->save();
    }
}

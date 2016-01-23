<?php

namespace app\auth\models;

use app\profile\enums\UserRole;
use app\core\models\User;
use Yii;
use yii\base\Model;

class RegistrationForm extends Model {

    public $name;
    public $email;
    public $password;
    public $agreementAccepted = true;

    /**
     * @return array
     */
    public function rules() {
        return [
            [['email', 'password'], 'required'],
            ['email', 'email'],
            ['name', 'string', 'max' => 255],
            ['agreementAccepted', function ($attribute, $params) {
                if (!$this->$attribute) {
                    $this->addError($attribute, Yii::t('app', 'Вы должны принять условия пользовательского соглашения чтобы зарегистрироваться.'));
                }
            }],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels() {
        return [
            'name' => 'Имя',
            'email' => 'Email',
            'password' => 'Пароль',
            'agreementAccepted' => '',
        ];
    }

    public function register() {
        if (!$this->validate()) {
            return false;
        }

        $user = new User();
        $user->attributes = $this->attributes;
        $user->password = $user->passwordToHash($this->password);
        $user->role = UserRole::USER;

        if (!$user->save()) {
            $this->addErrors($user->getErrors());
            return false;
        }

        \Yii::$app->mailer
            ->compose('@app/auth/mail/registration', [
                'user' => $user
            ])
            ->setTo($user->email)
            ->send();

        return true;
    }

}

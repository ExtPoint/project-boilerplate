<?php

namespace app\auth\models;

use app\core\models\User;
use Yii;
use yii\base\Model;
use yii\helpers\Url;

class PasswordRecoveryKeyForm extends Model {

    public $email;
    public $captcha;

    /**
     * @return array
     */
    public function rules() {
        return [
            [['email', 'captcha'], 'required', 'message' => Yii::t('app', 'Необходимо указать символы с картинки')],
            [['email'], 'exist', 'targetClass' => 'app\core\models\User',
                'message' => Yii::t('app', 'Пользователя с указанным e-mail не существует'),
            ],
            [['captcha'], 'captcha', 'captchaAction' => 'auth/recovery/captcha'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels() {
        return [
            'email' => Yii::t('app', 'E-mail'),
            'captcha' => Yii::t('app', 'Символы с картинки'),
        ];
    }

    /**
     * Sends password recovery instructions via e-mail.
     * @return bool
     */
    public function send() {
        if (!$this->validate()) {
            return false;
        }

        /** @var User $user */
        $user = User::findByLogin($this->email);
        $user->recoveryKey = Yii::$app->getSecurity()->generateRandomString(32);
        $user->save(false);

        \Yii::$app->mailer
            ->compose('@app/auth/mail/recovery', [
                'user' => $user,
                'url' => Url::to(['/auth/recovery/code', 'code' => $user->recoveryKey], true),
            ])
            ->setTo($user->email)
            ->send();

        return true;
    }

}

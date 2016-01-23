<?php

namespace app\auth\models;

use app\core\models\User;
use Yii;
use yii\base\Exception;
use yii\base\Model;

class PasswordResetForm extends Model
{
	public $password;
	public $passwordAgain;
	public $captcha;

	/**
	 * @return array
	 */
	public function rules()
	{
		return [
			[['password', 'passwordAgain'], 'required'],
			['passwordAgain', 'compare', 'compareAttribute'=> 'password'],
		];
	}

	/**
	 * @return array
	 */
	public function attributeLabels()
	{
		return [
			'password' => Yii::t('app', 'Новый пароль'),
			'passwordAgain' => Yii::t('app', 'Подтвердите новый пароль'),
		];
	}

	/**
	 * @param string $key password recovery key.
	 * @return bool
	 */
	public static function keyExists($key)
	{
		return User::find()->where(['recoveryKey' => $key])->exists();
	}

	/**
	 * @param string $key password recovery key.
	 * @throws Exception if can't update model.
	 * @return bool
	 */
	public function resetPassword($key)
	{
        /** @var User $user */
		$user = User::find()->where(['recoveryKey' => $key])->one();
		if (!$user || !$this->validate()) {
			return false;
		}

		$user->password = $user->passwordToHash($this->password);

		if (!$user->validate(['password'])) {
			$this->addErrors($user->getErrors());
			return false;
		}

		$user->recoveryKey = null;
        $user->saveOrPanic();

        // Auto login
        Yii::$app->user->login($user);

		return true;
	}
}

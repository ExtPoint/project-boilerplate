<?php
namespace app\profile\enums;

use extpoint\yii2\base\AppEnum;

class UserRole extends AppEnum {

	const USER = 'user';
	const ADMIN = 'admin';

	public static function getLabels()
	{
		return [
			self::USER => 'Пользователь',
			self::ADMIN => 'Администратор'
		];
	}
}
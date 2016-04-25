<?php
namespace app\profile\enums;

use extpoint\yii2\base\Enum;

class UserRole extends Enum {

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
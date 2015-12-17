<?php

namespace app\core\base;

abstract class Enum {

	public static function getLabels() {
		return [];
	}

	/**
	 * @param string $id
	 * @throws \Exception if label doesn't exist
	 * @return mixed
	 */
	public static function getLabel($id)
	{
		$idLabelMap = static::getLabels();

		if (!isset($idLabelMap[$id])) {
			throw new \Exception('Unknown id: ' . $id);
		}
		return $idLabelMap[$id];
	}
}
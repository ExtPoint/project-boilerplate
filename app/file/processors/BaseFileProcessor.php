<?php

namespace app\file\processors;

use app\file\FileException;
use yii\base\Object;

class BaseFileProcessor extends Object {

	public $filePath;

	public function run() {
		if (!file_exists($this->filePath)) {
			throw new FileException('Not found file `' . $this->filePath . '`');
		}

		$this->runInternal();
	}

	protected function runInternal() {

	}

}
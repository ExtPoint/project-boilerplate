<?php

namespace app\file;

use app\core\base\AppModule;
use app\file\models\File;
use app\file\uploaders\BaseUploader;
use yii\helpers\ArrayHelper;

class FileModule extends AppModule {

	const PROCESSOR_NAME_ORIGINAL = 'original';
	const PROCESSOR_NAME_DEFAULT = 'default';

	/**
	 * Format is jpg or png
	 * @var string
	 */
	public $thumbFormat = 'jpg';

	/**
	 * From 0 to 100 percents
	 * @var string
	 */
	public $thumbQuality = 90;

	/**
	 * Absolute path to root user files dir
	 * @var string
	 */
	public $filesRootPath;

	/**
	 * Absolute url to root user files dir
	 * @var string
	 */
	public $filesRootUrl;

	/**
	 * The name of the x-sendfile header
	 * @var string
	 */
	public $xHeader = false;

	/**
	 * Maximum file size limit
	 * @var string
	 */
	public $fileMaxSize = '200M';

	/**
	 * Image settings
	 * @var array
	 */
	public $processors = [];

	public function init() {
		parent::init();

		// Default processors
		$this->processors = ArrayHelper::merge(
			[
				self::PROCESSOR_NAME_ORIGINAL => [
					'class' => '\app\file\processors\ImageResize',
					'width' => 1920,
					'height' => 1200
				],
				self::PROCESSOR_NAME_DEFAULT => [
					'class' => '\app\file\processors\ImageResize',
					'width' => 100,
					'height' => 100
				]
			],
			$this->processors
		);

		// Normalize and set default dir
		if ($this->filesRootPath === null) {
			$this->filesRootPath = dirname(\Yii::$app->getRequest()->getScriptFile()) . '/assets/';
		} else {
			$this->filesRootPath = rtrim($this->filesRootPath, '/') . '/';
		}
		if ($this->filesRootUrl === null) {
			$this->filesRootUrl = \Yii::getAlias('@web', false) . '/assets/';
		} else {
			$this->filesRootUrl = rtrim($this->filesRootUrl, '/') . '/';
		}
	}

    /**
     * @param array $uploaderConfig
     * @param array $fileConfig
     * @return \app\file\models\File[]
     * @throws \yii\base\InvalidConfigException
     */
    public function upload($uploaderConfig = [], $fileConfig = []) {
        /** @var BaseUploader $uploader */
        $uploader = \Yii::createObject(ArrayHelper::merge([
            'class' => empty($_FILES) ? '\app\file\uploaders\PutUploader' : '\app\file\uploaders\PostUploader',
            'destinationDir' => $this->filesRootPath,
            'maxFileSize' => $this->fileMaxSize,
        ], $uploaderConfig));

        if (!$uploader->upload()) {
            return [
                'errors' => $uploader->getFirstErrors(),
            ];
        }

        $files = [];
        foreach ($uploader->files as $item) {
            $file = new File();
            $file->attributes = ArrayHelper::merge($fileConfig, [
                'uid' => $item['uid'],
                'title' => $item['title'],
                'fileName' => $item['name'],
                'fileMimeType' => $item['type'],
                'fileSize' => $item['bytesTotal'],
            ]);

            if (!$file->save()) {
                return [
                    'errors' => $uploader->getFirstErrors(),
                ];
            }

            $files[] = $file;
        }

        return $files;
    }

    protected function coreUrlRules() {
        return [
            'file/<uid:[a-z0-9-]{36}>/<name>' => "$this->id/download/index",
        ];
    }

}
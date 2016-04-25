<?php

namespace app\file\models;

use app\core\base\AppModel;
use extpoint\yii2\behaviors\TimestampBehavior;
use app\file\processors\ImageCrop;
use app\file\processors\ImageCropResize;
use app\file\processors\ImageResize;
use app\file\FileException;
use app\file\FileModule;

/**
 * @property integer $id
 * @property string $fileUid
 * @property string $folder
 * @property string $fileName
 * @property string $fileMimeType
 * @property boolean $isOriginal
 * @property integer $width
 * @property integer $height
 * @property string $processor
 * @property integer $createTime
 * @property-read string $path
 * @property-read string $url
 */
class ImageMeta extends AppModel {

	public static function isImageMimeType($value) {
		return in_array($value, [
			'image/gif',
			'image/jpeg',
			'image/pjpeg',
			'image/png'
		]);
	}

	/**
	 * @return string
	 */
	public static function tableName() {
		return 'files_images_meta';
	}

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @return string
     */
	public function getRelativePath() {
		return $this->folder . $this->fileName;
	}

    /**
     * @return string
     * @throws \yii\base\Exception
     */
	public function getPath() {
		return FileModule::getInstance()->filesRootPath . $this->getRelativePath();
	}

    /**
     * @return string
     * @throws \yii\base\Exception
     */
	public function getUrl() {
		return FileModule::getInstance()->filesRootUrl . $this->getRelativePath();
	}

    /**
     * @return bool
     * @throws FileException
     */
	public function beforeDelete() {
		if (!parent::beforeDelete()) {
			return false;
		}

		// Delete file
		if (file_exists($this->getPath()) && !unlink($this->getPath())) {
			throw new FileException('Can not remove image thumb file `' . $this->getRelativePath() . '`.');
		}

		return true;
	}

	/**
	 * @param $fileUid
	 * @return static
	 */
	public static function findOriginal($fileUid) {
		return static::find()->where([
			'fileUid' => $fileUid,
			'isOriginal' => true
		])->one();
	}

	/**
	 * @param $fileUid
	 * @param string [$processorName]
	 * @return ImageMeta
	 * @throws FileException
	 * @throws \yii\base\Exception
	 */
	public static function findByProcessor($fileUid, $processorName = FileModule::PROCESSOR_NAME_DEFAULT) {
		// Check already exists
		/** @var self $imageMeta */
		$imageMeta = self::findOne([
			'fileUid' => $fileUid,
			'processor' => $processorName,
		]);
		if ($imageMeta) {
			return $imageMeta;
		}

		$imageMeta = static::cloneOriginal($fileUid, $processorName);
		$imageMeta->process($processorName);
		$imageMeta->processor = $processorName;
		$imageMeta->save();
		return $imageMeta;
	}

    /**
     * @param string|array $params
     * @throws FileException
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function process($params) {
        if (is_string($params)) {
            $processors = FileModule::getInstance()->processors;
            if (!isset($processors[$params])) {
                throw new FileException('Not found processor by name `' . $params . '`');
            }
            $params = $processors[$params];
        }

        /** @var ImageCrop|ImageCropResize|ImageResize $processor */
        $processor = \Yii::createObject($params);
        $processor->filePath = $this->getPath();
        $processor->thumbQuality = FileModule::getInstance()->thumbQuality;
        $processor->run();

        if (isset($params['width']) && isset($params['height'])) {
            $this->width = $processor->width;
            $this->height = $processor->height;
        }
    }

	protected static function cloneOriginal($fileUid, $suffix) {
		// Get original image
		/** @var self $originalMeta */
		$originalMeta = self::findOriginal($fileUid);
		if (!$originalMeta) {
			throw new FileException('Not found original image by uid `' . $fileUid . '`.');
		}

		// New file meta
		$imageMeta = new self();
		$imageMeta->fileUid = $originalMeta->fileUid;
		$imageMeta->folder = $originalMeta->folder;
		$imageMeta->fileMimeType = $originalMeta->fileMimeType;

		// Generate new file name
		$extension = pathinfo($originalMeta->fileName, PATHINFO_EXTENSION);
		$thumbFormat = $extension && $extension === 'png' ? 'png' : FileModule::getInstance()->thumbFormat;
		$imageMeta->fileName = pathinfo($originalMeta->fileName, PATHINFO_FILENAME) . '.' . $suffix . '.' . $thumbFormat;

		// Clone original file
		if (!copy($originalMeta->getPath(), $imageMeta->getPath())) {
			throw new FileException('Can not clone original file `' . $originalMeta->getRelativePath() . '` to `' . $imageMeta->getRelativePath() . '`.');
		}
		return $imageMeta;
	}

}
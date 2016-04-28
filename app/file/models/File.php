<?php

namespace app\file\models;

use app\core\base\AppModel;
use extpoint\yii2\behaviors\TimestampBehavior;
use extpoint\yii2\behaviors\UidBehavior;
use app\file\FileException;
use app\file\FileModule;
use yii\helpers\Url;

/**
 * @property string $uid
 * @property string $title
 * @property string $folder
 * @property string $fileName
 * @property string $fileMimeType
 * @property string $fileSize
 * @property integer $createTime
 * @property boolean $isTemp
 * @property-read string $path
 * @property-read string $url
 * @property-read string $downloadUrl
 * @property-read string $downloadName
 */
class File extends AppModel {

	const LIVE_TYPE_TILL_TIME = 'till_time';
	const LIVE_TYPE_PERSISTENT = 'persistent';

	/**
	 * @return string
	 */
	public static function tableName() {
		return 'files';
	}

    /**
     * @param string $url
     * @return static
     */
    public static function findByUrl($url) {
        // Find uid
        if (preg_match('/[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}/', $url, $match)) {
            return static::findOne($match[0]);
        }
        return null;
    }

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            UidBehavior::className(),
            TimestampBehavior::className(),
        ];
    }

	/**
	 * @return array
	 */
	public function rules()	{
		return [
			['isTemp', 'boolean'],
			['title', 'filter', 'filter' => function($value) {
                return preg_replace('/^[^\\\\\/]*[\\\\\/]/', '', $value);
			}],
			['title', 'string', 'max' => 255],
			['folder', 'match', 'pattern' => '/^[a-z0-9+-_\/.]+$/i'],
			['folder', 'filter', 'filter' => function($value) {
				return rtrim($value, '/') . '/';
			}],
			['fileName', 'string'],
			['fileSize', 'integer'],
			['fileMimeType', 'default', 'value' => 'text/plain'],
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

    public function getDownloadName() {
        $ext = '.' . pathinfo($this->fileName, PATHINFO_EXTENSION);
        return $this->title . (substr($this->title, -4) !== $ext ? $ext : '');
    }

    /**
     * @return string
     * @throws \yii\base\Exception
     */
	public function getDownloadUrl() {
        return Url::to(['/file/download/index', 'uid' => $this->uid, 'name' => $this->getDownloadName()], true);
	}

	public function getPreviewImageUrl() {
		if (ImageMeta::isImageMimeType($this->fileMimeType)) {
			try {
				return ImageMeta::findByProcessor($this->uid, FileModule::PROCESSOR_NAME_DEFAULT)->url;
			} catch (FileException $e) {
				// @todo change mime type on error for cache
			}
		}
		return null;
	}

	public function getIconName() {
		$ext = pathinfo($this->fileName, PATHINFO_EXTENSION);
		$ext = preg_replace('/[^0-9a-z_]/', '', $ext);
		$iconPath = __DIR__ . '/../../../client/images/fileIcons/' . $ext . '.png';

		return file_exists($iconPath) ? $ext : 'default';
	}

	public function beforeDelete() {
		if (!parent::beforeDelete()) {
			return false;
		}

		// Remove image meta info
		/** @var ImageMeta[] $imagesMeta */
		$imagesMeta = ImageMeta::findAll(['fileUid' => $this->uid]);
		foreach ($imagesMeta as $imageMeta) {
			if (!$imageMeta->delete()) {
				throw new FileException('Can not remove image meta `' . $imageMeta->getRelativePath() . '` for file `' . $this->uid . '`.');
			}
		}

		// Delete file
		if (file_exists($this->getPath()) && !unlink($this->getPath())) {
			throw new FileException('Can not remove file file `' . $this->getRelativePath() . '`.');
		}

		// Check to delete empty folders
		$filesRootPath = FileModule::getInstance()->filesRootPath;
		$folderNames = explode('/', trim($this->folder, '/'));
		foreach ($folderNames as $i => $folderName) {
			$folderPath = implode('/', array_slice($folderNames, 0, count($folderNames) - $i)) . '/';
			$folderAbsolutePath = $filesRootPath . $folderPath;

			// Check dir exists
			if (!file_exists($folderAbsolutePath)) {
				continue;
			}

			// Skip, if dir is not empty
			$handle = opendir($folderAbsolutePath);
			while (false !== ($entry = readdir($handle))) {
				if ($entry != "." && $entry != "..") {
					break 2;
				}
			}

			// Remove folder
			if (!rmdir($folderAbsolutePath)) {
				throw new FileException('Can not remove empty folder `' . $folderPath . '`.');
			}
		}

		return true;
	}

    public function afterSave($insert, $changedAttributes) {
        // Create ImageMeta for images
        if ($insert && ImageMeta::isImageMimeType($this->fileMimeType)) {

            // Create instance
            $imageMeta = new ImageMeta([
                'fileUid' => $this->uid,
                'folder' => $this->folder,
                'fileName' => $this->fileName,
                'fileMimeType' => $this->fileMimeType,
                'isOriginal' => true,
                'processor' => FileModule::PROCESSOR_NAME_ORIGINAL,
            ]);

            // Save
            $imageMeta->process(FileModule::PROCESSOR_NAME_ORIGINAL);
            $imageMeta->saveOrPanic();
        }

        parent::afterSave($insert, $changedAttributes);
    }

	public function getExtendedAttributes() {
		return $this->attributes + [
			'url' => $this->getUrl(),
			'downloadUrl' => $this->getDownloadUrl(),
			'previewImageUrl' => $this->getPreviewImageUrl(),
			'iconName' => $this->getIconName(),
		];
	}

}
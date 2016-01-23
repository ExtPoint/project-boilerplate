<?php

namespace app\file\processors;

class ImageCrop extends BaseFileProcessor {

	/**
	 * @var int
	 */
	public $width;

	/**
	 * @var int
	 */
	public $height;

	/**
	 * @var int
	 */
	public $offsetX;

	/**
	 * @var int
	 */
	public $offsetY;

	/**
	 * @var int
	 */
	public $thumbQuality = 90;

	protected function runInternal() {
		$imageContent = file_get_contents($this->filePath);
		list($originalWidth, $originalHeight) = getimagesizefromstring($imageContent);

		// Check if crop is smaller or equal than original image
		$isCropSizeCorrect = ($originalWidth >= $this->width) && ($originalHeight >= $this->height);

		// Check if crop offset doesn't exceed original image
		$isCropOffsetCorrect = ($this->offsetX < $originalWidth) && ($this->offsetY < $originalHeight);

		// Leaving image intact when crop sizes or offsets are incorrect
		if(!$isCropSizeCorrect || !$isCropOffsetCorrect) {
			$this->width = $originalWidth;
			$this->height = $originalHeight;
			return;
		}

		$bool = true;
		$src = imagecreatefromstring($imageContent);
		$extension = pathinfo($this->filePath, PATHINFO_EXTENSION);

		// Auto-rotate
		if ($extension === 'jpg' || $extension === 'jpeg') {
			try {
				$exif = exif_read_data($this->filePath);
			} catch (\Exception $e) {};

			if (!empty($exif['Orientation'])) {
				switch ($exif['Orientation']) {
					case 3:
						$src = imagerotate($src, 180, 0);
						break;

					case 6:
						$src = imagerotate($src, -90, 0);
						break;

					case 8:
						$src = imagerotate($src, 90, 0);
						break;
				}
			}
		}

		// Create blank image
		$dst = ImageCreateTrueColor($this->width, $this->height);
		if ($extension === 'png') {
			$bool = $bool && imagesavealpha($dst, true) && imagealphablending($dst, false);
		}

		// Place, resize and save file

		$bool = $bool && imagecopyresampled($dst, $src, 0, 0, $this->offsetX, $this->offsetY, $this->width, $this->height, $this->width, $this->height);
		$bool && $extension === 'png' ?
			imagepng($dst, $this->filePath) :
			imagejpeg($dst, $this->filePath, $this->thumbQuality);

		// Clean
		if ($src) {
			imagedestroy($src);
		}
		if ($dst) {
			imagedestroy($dst);
		}
	}

}
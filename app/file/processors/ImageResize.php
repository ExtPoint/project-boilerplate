<?php

namespace app\file\processors;

class ImageResize extends BaseFileProcessor {

	/**
	 * @var int
	 */
	public $width;

	/**
	 * @var int
	 */
	public $height;

	/**
	 * @var boolean
	 */
	public $isFit = true;

	/**
	 * @var int
	 */
	public $thumbQuality = 90;

	protected function runInternal() {
		$imageContent = file_get_contents($this->filePath);

		// New size
		list($originalWidth, $originalHeight) = getimagesizefromstring($imageContent);

		$scale = $this->isFit ?
			min($this->width / $originalWidth, $this->height / $originalHeight) :
			max($this->width / $originalWidth, $this->height / $originalHeight);

		$this->width = max(1, (int) floor($originalWidth * $scale));
		$this->height = max(1, (int) floor($originalHeight * $scale));

		// Check need resize
		if ($scale >= 1) {
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
			} catch (\Exception $e) {}

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
		$bool = $bool && imagecopyresampled($dst, $src, 0, 0, 0, 0, $this->width, $this->height, $originalWidth, $originalHeight);
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
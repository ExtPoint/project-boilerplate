<?php

namespace app\file\processors;

class ImageCropResize extends BaseFileProcessor {

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
	public $thumbQuality = 90;

	protected function runInternal() {
		list($originalWidth, $originalHeight) = getimagesize($this->filePath);

		// Defaults offset - center
		$minOriginalSize = min($originalWidth, $originalHeight);
		if ($this->width > $this->height) {
			$cropWidth = $minOriginalSize;
			$cropHeight = (int) floor($minOriginalSize * ($this->height / $this->width));
		} else {
			$cropWidth = $minOriginalSize;
			$cropHeight = (int) floor($minOriginalSize * ($this->width / $this->height));
		}

		// Crop
		$cropProcessor = new ImageCrop([
			'filePath' => $this->filePath,
			'width' => $cropWidth,
			'height' => $cropHeight,
			'thumbQuality' => $this->thumbQuality,
			'offsetX' => round(($originalWidth - $cropWidth) / 2),
			'offsetY' => round(($originalHeight - $cropHeight) / 2),
		]);
		$cropProcessor->run();

		// Resize
		$fitProcessor = new ImageResize([
			'filePath' => $this->filePath,
			'width' => $this->width,
			'height' => $this->height,
			'thumbQuality' => $this->thumbQuality,
		]);
		$fitProcessor->run();
		$this->width = $fitProcessor->width;
		$this->height = $fitProcessor->height;
	}
}
<?php

namespace app\file\uploaders;

use app\file\FileException;

class PutUploader extends BaseUploader {

    protected $contentRange;

	protected function fetchFiles() {
		// Parse the Content-Disposition header
		$fileName = null;
		if (!empty($_SERVER['HTTP_CONTENT_DISPOSITION'])) {
			$fileName = rawurldecode(preg_replace('/(^[^"]+")|("$)/', '', $_SERVER['HTTP_CONTENT_DISPOSITION']));
		}
		if (!$fileName) {
            throw new FileException('Not found file name in request.');
		}

		// Parse the Content-Range header, which has the following form:
		// Content-Range: bytes 0-524287/2000000
		$this->contentRange = null;
		if (!empty($_SERVER['HTTP_CONTENT_RANGE']) && preg_match('/([0-9]+)-([0-9]+)\/([0-9]+)/', $_SERVER['HTTP_CONTENT_RANGE'], $match)) {
			$this->contentRange = [
				'start' => (int) $match[1],
				'end' => (int) $match[2],
				'total' => (int) $match[3],
			];
		}

		// Get file size
		$fileSize = null;
		if ($this->contentRange) {
			$fileSize = $this->contentRange['total'];
		} elseif (!empty($_SERVER['CONTENT_LENGTH'])) {
			$fileSize = $_SERVER['CONTENT_LENGTH'];
		}

		// Get file type
		$fileType = null;
		if (!empty($_SERVER['CONTENT_TYPE'])) {
			$fileType = $_SERVER['CONTENT_TYPE'];
		}

        $uid = !empty($_GET['uids'][0]) ? $_GET['uids'][0] : UidBehavior::generate();
		return [
			[
				'uid' => $uid,
				'name' => self::generateFileName($fileName, $uid),
				'title' => $fileName,
				'bytesUploaded' => $this->contentRange ? $this->contentRange['end'] : $fileSize,
				'bytesTotal' => $this->contentRange ? $this->contentRange['total'] : $fileSize,
				'type' => $fileType,
				'path' => null,
			]
		];
	}

    protected function uploadInternal() {
	    $file = $this->files[0];

	    $filePath = $this->getFilePath($file['name']);

	    if ($this->contentRange) {
		    // Check file exists and correct size
		    if ($this->contentRange['start'] > 0 && !is_file($filePath)) {
                $this->addError('files', \Yii::t('app', 'Not found file for append content.'));
                return false;
		    }

		    $backendFileSize = filesize($filePath);

		    // Check file size on server
		    if ($this->contentRange['start'] > $backendFileSize) {
                $this->addError('files', \Yii::t('app', 'Incorrect content range size for append content.'));
                return false;
		    }

		    // Truncate file, if it more than content-range start
		    if ($this->contentRange['start'] < $backendFileSize) {
			    $handle = fopen($filePath, 'r+');
			    ftruncate($handle, $this->contentRange['start']);
			    rewind($handle);
			    fclose($handle);
		    }
	    }

	    // Check file size
	    if ($file['bytesTotal'] && $file['bytesTotal'] > $this->maxFileSize) {
            $this->addError('maxFileSize', \Yii::t('app', 'The uploaded file is too large. Max size: {size} Mb', [
                'size' => round(($this->maxFileSize / 1024) / 1024),
            ]));
            return false;
	    }

	    // Check request max size
	    if ($file['bytesTotal'] && $file['bytesTotal'] > $this->maxRequestSize) {
            $this->addError('maxRequestSize', \Yii::t('app', 'Summary uploaded files size is too large. Available size: {size} Mb', [
                'size' => round(($this->maxRequestSize / 1024) / 1024),
            ]));
            return false;
	    }

        // Upload file content
        file_put_contents(
            $filePath,
            fopen('php://input', 'r'),
	        $this->contentRange && $this->contentRange['start'] > 0 ? FILE_APPEND : 0
        );

        // Get in from file, if no exists
	    $file['bytesTotal'] = $file['bytesTotal'] ?: filesize($filePath);
	    $file['bytesUploaded'] = $file['bytesUploaded'] ?: $file['bytesUploaded'];
	    $file['type'] = $file['type'] ?: filetype($filePath);

	    $this->files[0] = $file;
        return true;
    }

}

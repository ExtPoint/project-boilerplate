<?php

use yii\db\Schema;
use yii\db\Migration;

class m160122_150406_file_init_tables extends Migration {
    public function up() {

        $this->createTable('files', [
            'id' => $this->primaryKey(),
            'uid' => $this->string(36),
            'title' => $this->string(),
            'folder' => $this->string(),
            'fileName' => $this->string(),
            'fileMimeType' => $this->string(),
            'fileSize' => $this->integer(),
            'createTime' => $this->dateTime(),
            'updateTime' => $this->dateTime(),
            'isTemp' => $this->boolean(),
        ]);
        $this->createIndex('uid', 'files', 'uid');

        $this->createTable('files_images_meta', [
            'id' => $this->primaryKey(),
            'fileId' => $this->integer(),
            'folder' => $this->string(),
            'fileName' => $this->string(),
            'fileMimeType' => $this->string(),
            'isOriginal' => $this->boolean(),
            'width' => $this->smallInteger(),
            'height' => $this->smallInteger(),
            'processor' => $this->string(),
            'createTime' => $this->dateTime(),
            'updateTime' => $this->dateTime(),
        ]);
        $this->createIndex('file_processor', 'files_images_meta', [
            'fileId',
            'processor',
        ]);
        $this->createIndex('original', 'files_images_meta', [
            'fileId',
            'isOriginal',
        ]);
    }

    public function down() {
        $this->dropTable('files');
        $this->dropTable('files_images_meta');
    }

}

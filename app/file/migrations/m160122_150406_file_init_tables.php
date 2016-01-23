<?php

use yii\db\Schema;
use yii\db\Migration;

class m160122_150406_file_init_tables extends Migration {
    public function up() {

        $this->createTable('files', [
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
        $this->addPrimaryKey('uid', 'files', 'uid');

        $this->createTable('files_images_meta', [
            'id' => $this->primaryKey(),
            'fileUid' => $this->string(36),
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
            'fileUid',
            'processor',
        ]);
        $this->createIndex('original', 'files_images_meta', [
            'fileUid',
            'isOriginal',
        ]);
    }

    public function down() {
        $this->dropTable('files');
        $this->dropTable('files_images_meta');
    }

}

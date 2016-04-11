<?php

use yii\db\Migration;

class m160407_093325_content_init extends Migration {

    public function up() {
        $this->createTable('contents', [
            'uid' => $this->string(36),
            'creatorUserUid' => $this->string(36),
            'type' => $this->string(),
            'category' => $this->string(),
            'image' => $this->string(),
            'name' => $this->string(),
            'title' => $this->string(),
            'previewText' => $this->text(),
            'text' => $this->text(),
            'isPublished' => $this->boolean(),
            'publishTime' => $this->dateTime()->notNull(),
            'createTime' => $this->dateTime()->notNull(),
            'updateTime' => $this->dateTime()->notNull(),
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
        $this->addPrimaryKey('uid', 'contents', 'uid');
    }

    public function down() {
        $this->dropTable('contents');
    }

}

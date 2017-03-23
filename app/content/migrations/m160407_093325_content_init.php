<?php

use yii\db\Migration;

class m160407_093325_content_init extends Migration {

    public function up() {
        $base = [
            'id' => $this->primaryKey(),
            'creatorUserId' => $this->integer(),
            'name' => $this->string(),
            'title' => $this->string(),
            'text' => $this->text(),
            'isPublished' => $this->boolean(),
            'createTime' => $this->dateTime()->notNull(),
            'updateTime' => $this->dateTime()->notNull(),
        ];
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('content_articles', $base + [
            'type' => $this->string(),
            'category' => $this->string(),
            'image' => $this->string(),
            'previewText' => $this->text(),
            'publishTime' => $this->dateTime()->notNull(),
        ], $tableOptions);

        $this->createTable('content_pages', $base + [
            'metaKeywords' => $this->string(),
            'metaDescription' => $this->string(),
            'parentId' => $this->integer(),
            'redirectToId' => $this->integer(),
        ], $tableOptions);

        $this->createTable('content_texts', $base, $tableOptions);

    }

    public function down() {
        $this->dropTable('content_articles');
        $this->dropTable('content_pages');
        $this->dropTable('content_texts');
    }

}

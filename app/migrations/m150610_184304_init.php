<?php

use yii\db\Schema;
use yii\db\Migration;

class m150610_184304_init extends Migration
{
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%products}}', [
            'id' => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING . ' NOT NULL',
            'description' => Schema::TYPE_TEXT,
            'createTime' => Schema::TYPE_TIMESTAMP,
            'updateTime' => Schema::TYPE_TIMESTAMP,
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%products}}');
    }
}

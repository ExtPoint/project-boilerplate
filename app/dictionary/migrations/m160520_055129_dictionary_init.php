<?php

use yii\db\Migration;

class m160520_055129_dictionary_init extends Migration
{
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('dictionary', [
            'type' => $this->string(),
            'name' => $this->string(),
            'title' => $this->string(),
            'createTime' => $this->dateTime()->notNull(),
            'updateTime' => $this->dateTime()->notNull(),
        ], $tableOptions);
        $this->addPrimaryKey('pk', 'dictionary', ['type', 'name']);
    }

    public function down()
    {
        $this->dropTable('dictionary');
    }
}

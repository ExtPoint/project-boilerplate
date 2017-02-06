<?php

use yii\db\Migration;

class m170203_120846_add_table_auth_service extends Migration
{
    public function safeUp()
    {
        $this->createTable('auth_social_connections', [
            'uid' => 'varchar(36) NOT NULL Primary Key',
            'userUid' => 'varchar(36) NULL',
            'source' => 'string NOT NULL',
            'sourceId' => 'string NOT NULL',
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('auth_social_connections');
    }
}

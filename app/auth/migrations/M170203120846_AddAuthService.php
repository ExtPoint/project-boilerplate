<?php

namespace app\auth\migrations;

use yii\db\Migration;

class M170203120846_AddAuthService extends Migration
{
    public function safeUp()
    {
        $this->createTable('auth_social_connections', [
            'id' => $this->primaryKey(),
            'userId' => $this->integer(),
            'source' => 'string NOT NULL',
            'sourceId' => 'string NOT NULL',
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('auth_social_connections');
    }
}

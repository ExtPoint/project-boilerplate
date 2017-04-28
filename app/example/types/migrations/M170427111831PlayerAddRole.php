<?php

namespace app\example\types\migrations;

use extpoint\yii2\base\Migration;

class M170427111831PlayerAddRole extends Migration
{
    public function up() {
        $this->addColumn('example_types_players', 'role', $this->string());
    }

    public function down() {
        $this->dropColumn('example_types_players', 'role');
    }
}

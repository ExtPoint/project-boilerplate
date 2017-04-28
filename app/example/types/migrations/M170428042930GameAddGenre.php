<?php

namespace app\example\types\migrations;

use extpoint\yii2\base\Migration;

class M170428042930GameAddGenre extends Migration
{
    public function up() {
        $this->addColumn('example_types_games', 'genre', $this->string());
    }

    public function down() {
        $this->dropColumn('example_types_games', 'genre');
    }
}

<?php

namespace app\example\types\migrations;

use extpoint\yii2\base\Migration;

class M170427093924GameUpdSaleFromSaleTo extends Migration
{
    public function up() {
        $this->alterColumn('example_types_games', 'saleFrom', $this->date());
        $this->alterColumn('example_types_games', 'saleTo', $this->date());
    }

    public function down() {
        $this->dropColumn('example_types_games', 'saleFrom');
        $this->dropColumn('example_types_games', 'saleTo');
    }
}

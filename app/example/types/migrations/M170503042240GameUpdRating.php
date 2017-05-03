<?php

namespace app\example\types\migrations;

use extpoint\yii2\base\Migration;

class M170503042240GameUpdRating extends Migration
{
    public function up()
    {
        $this->alterColumn('example_types_games', 'rating', $this->integer()->notNull()->defaultValue(0));
    }

    public function down()
    {
        $this->alterColumn('example_types_games', 'rating', $this->integer());
    }
}

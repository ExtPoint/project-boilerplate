<?php

namespace app\example\types\migrations;

use extpoint\yii2\base\Migration;

class M170417105919_Example_types_games extends Migration
{
    public function up() {
        $this->createTable('example_types_games', [
            'id' => $this->primaryKey(),
            'createTime' => $this->dateTime(),
            'updateTime' => $this->dateTime(),
            'title' => $this->string(),
            'shortDescription' => $this->text(),
            'fullDescription' => $this->text(),
            'rating' => $this->integer(),
            'isDisabled' => $this->boolean(),
            'price' => $this->decimal(19, 4),
            'tillDate' => $this->date(),
            'logoId' => $this->integer(),
            'winExeId' => $this->integer(),
            'macDmgId' => $this->integer(),
            'creatorId' => $this->integer(),
        ]);
    }

    public function down() {
        $this->dropTable('example_types_games');
    }
}

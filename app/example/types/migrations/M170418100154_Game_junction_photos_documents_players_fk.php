<?php

namespace app\example\types\migrations;

use extpoint\yii2\base\Migration;

class M170418100154_Game_junction_photos_documents_players_fk extends Migration
{
    public function up() {
        $this->createTable('example_types_games_photos', [
            'gameId' => $this->integer()->notNull(),
            'fileId' => $this->integer()->notNull(),
        ]);
        $this->createTable('example_types_games_documents', [
            'gameId' => $this->integer()->notNull(),
            'fileId' => $this->integer()->notNull(),
        ]);
        $this->createTable('example_types_games_players', [
            'gameId' => $this->integer()->notNull(),
            'playerId' => $this->integer()->notNull(),
        ]);
        $this->createForeignKey('example_types_games', 'logoId', '{{%files}}', 'id');
        $this->createForeignKey('example_types_games', 'winExeId', '{{%files}}', 'id');
        $this->createForeignKey('example_types_games', 'macDmgId', '{{%files}}', 'id');
        $this->createForeignKey('example_types_games', 'creatorId', 'example_types_players', 'id');
    }

    public function down() {
        $this->deleteForeignKey('example_types_games', 'logoId', '{{%files}}', 'id');
        $this->deleteForeignKey('example_types_games', 'winExeId', '{{%files}}', 'id');
        $this->deleteForeignKey('example_types_games', 'macDmgId', '{{%files}}', 'id');
        $this->deleteForeignKey('example_types_games', 'creatorId', 'example_types_players', 'id');
        $this->dropTable('example_types_games_photos');
        $this->dropTable('example_types_games_documents');
        $this->dropTable('example_types_games_players');
    }
}

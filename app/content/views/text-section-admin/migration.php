<?php

namespace app\views;

use app\content\models\TextSection;

/* @var $migrationName string */
/* @var $model \app\content\models\TextSection */

?>
<?= '<?php' ?>

use yii\db\Migration;

class <?= $migrationName ?> extends Migration {

    public function up() {
        $this->insert('<?= TextSection::tableName() ?>', [
            'uid' => '<?= $model->uid ?>',
            'creatorUserUid' => '<?= $model->creatorUserUid ?>',
            'name' => '<?= trim($model->name) ?>',
            'title' => '<?= trim($model->title) ?>',
            'text' => '<?= trim($model->text) ?>',
            'isPublished' => '<?= $model->isPublished ?>',
            'publishTime' => '<?= $model->publishTime ?>',
            'createTime' => '<?= $model->createTime ?>',
            'updateTime' => '<?= $model->updateTime ?>',
        ]);
    }

    public function down() {
        $this->delete('<?= TextSection::tableName() ?>', ['uid' => '<?= $model->uid ?>']);
    }
}

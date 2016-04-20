<?php

namespace app\content\models;

use app\content\enums\ContentType;
use Yii;
use yii\helpers\Html;

class ContentText extends Content {

    public function attributes() {
        return array_diff(parent::attributes(), [
            'category',
            'previewText',
        ]);
    }

    public static function render($name, $titleTag = null) {
        $model = self::findOne([
            'type' => ContentType::TEXT,
            'name' => $name,
        ]);
        
        if ($model && $model->isPublished) {
            $tag = $titleTag ? Html::tag($titleTag, $model->title) : '';
            return $tag . $model->text;
        }
        
        return '';
    }
    
    public function createMigration() {
        $date = date('ymd_His');
        $migrationName = "m{$date}_add_text_$this->name";

        $content = "<?php
            use yii\\db\\Migration;
            class $migrationName extends Migration
            {
                public function up()
                {
                    \$this->insert('contents', [
                        'uid' => '$this->uid',
                        'creatorUserUid' => '$this->creatorUserUid',
                        'type' => '$this->type',
                        'name' => '$this->name',
                        'title' => '$this->title',
                        'text' => '$this->text',
                        'isPublished' => '$this->isPublished',
                        'publishTime' => '$this->publishTime',
                        'createTime' => '$this->createTime',
                        'updateTime' => '$this->updateTime',
                    ]);
                }
                public function down() {
                    \$this->delete('contents', ['uid' => '$this->uid']);
                }
            }
        ";

        file_put_contents(Yii::getAlias('@app') . "/content/migrations/$migrationName.php", $content);

        Yii::$app->db->createCommand()->insert('migration', [
            'version' => $migrationName,
            'apply_time' => time(),
        ])->execute();
    }
}
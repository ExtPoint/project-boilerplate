<?php

namespace app\content\models;

use Yii;
use yii\helpers\Html;

class TextSection extends BaseContent {

    public static function tableName() {
        return 'content_texts';
    }

    /**
     * @param string $name
     * @param null|string $titleTag
     * @return string
     */
    public static function render($name, $titleTag = null) {
        $model = self::findOne([
            'name' => $name,
        ]);
        
        if ($model && $model->isPublished) {
            $tag = $titleTag ? Html::tag($titleTag, $model->title) . "\n" : '';
            return $tag . $model->text;
        }
        
        return '';
    }
    
    public function createMigration() {
        $migrationName = 'm' . date('ymd_His') . '_add_text_' . $this->name;

        // Save file
        $content = Yii::$app->view->renderFile('@app/content/views/text-section-admin/migration.php', [
            'model' => $this,
            'migrationName' => $migrationName,
        ]);
        file_put_contents(Yii::getAlias('@app') . "/content/migrations/$migrationName.php", $content);

        // Apply local
        Yii::$app->db->createCommand()->insert('migration', [
            'version' => $migrationName,
            'apply_time' => time(),
        ])->execute();
    }

}
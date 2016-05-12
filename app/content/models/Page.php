<?php

namespace app\content\models;

use app\content\enums\ContentType;
use Yii;

/**
 * @property string $parentUid
 * @property string $redirectToUid
 * @property string $metaKeywords
 * @property string $metaDescription
 * @property-read Page $redirectPage
 */
class Page extends BaseContent {

    public static function tableName() {
        return 'content_pages';
    }

    public static function getMenuItems() {
        // @todo cache
        // @todo return tree (analyze item name)

        if (!in_array(static::tableName(), Yii::$app->db->schema->tableNames)) {
            return [];
        }

        return array_map(function($pageModel) {
            /** @type Page $pageModel */
            return [
                'label' => $pageModel->title,
                'url' => ["/content/page/view", 'name' => $pageModel->name],
                'urlRule' => $pageModel->name,
            ];
        }, static::find()->where(['isPublished' => true])->all());
    }

    public function getRedirectPage() {
        return $this->hasOne(static::className(), ['uid' => 'redirectToUid']);
    }

}

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

    const CACHE_KEY_MENU_ITEMS = 'menuItems';

    public static function tableName() {
        return 'content_pages';
    }

    public function rules() {
        return array_merge(parent::rules(), [
            [['parentUid'], 'string', 'max' => 255],
        ]);
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), [
            'parentUid' => 'Родительская страница',
        ]);
    }

    public function afterSave($insert, $changedAttributes){
        parent::afterSave($insert, $changedAttributes);

        if (Yii::$app->has('cache')) {
            Yii::$app->cache->delete(self::CACHE_KEY_MENU_ITEMS);
        }
    }

    protected static function createTree($models, $array = [], $parentUid = null, $parentUrlRule = '') {
        foreach ($models as $key => $model) {
            if ($model->parentUid == $parentUid) {
                $array[$model->primaryKey] = [
                    'label' => $model->title,
                    'url' => ['/content/page/view', 'uid' => $model->uid],
                    'urlRule' => $parentUrlRule . '/' . $model->name,
                    'items' => [],
                ];
                unset($models[$key]);
            }
        }

        foreach ($array as $key => $item) {
            $array[$key]['items'] = self::createTree($models, $item['items'], $key, $item['urlRule']);
        }

        return $array;
    }

    public static function getMenuItems() {
        if (!in_array(static::tableName(), Yii::$app->db->schema->tableNames)) {
            return [];
        }

        $menuItems = Yii::$app->has('cache') ? Yii::$app->cache->get(self::CACHE_KEY_MENU_ITEMS) : false;

        if (!$menuItems) {
            $models = static::find()->where(['isPublished' => true])->all();
            $menuItems = self::createTree($models);

            if (Yii::$app->has('cache')) {
                Yii::$app->cache->set(self::CACHE_KEY_MENU_ITEMS, $menuItems);
            }
        }

        return $menuItems;
    }

    public function getRedirectPage() {
        return $this->hasOne(static::className(), ['uid' => 'redirectToUid']);
    }

}

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

    public function afterSave($insert, $changedAttributes){
        parent::afterSave($insert, $changedAttributes);
        Yii::$app->cache->delete(self::CACHE_KEY_MENU_ITEMS);
    }

    public static function addItemToTree($array, $model) {
        if (!$model->parentUid) {
            $array[$model->uid] = [
                'label' => $model->title,
                'url' => ['/content/page/view', 'name' => $model->name],
                'urlRule' => $model->name,
                'items' => [],
            ];
        } elseif (array_key_exists($model->parentUid, $array)) {
            $array[$model->parentUid]['items'][$model->uid] = [
                'label' => $model->title,
                'url' => ['/content/page/view', 'name' => $model->name],
                'urlRule' => $array[$model->parentUid]['urlRule'] . '/' . $model->name,
                'items' => [],
            ];
        } else {
            foreach($array as $key => $value) {
                $array[$key]['items'] = self::addItemToTree($value['items'], $model);
            }
        }
        return $array;
    }

    public static function getMenuItems() {
        if (!in_array(static::tableName(), Yii::$app->db->schema->tableNames)) {
            return [];
        }

        $menuItems = Yii::$app->cache ? Yii::$app->cache->get(self::CACHE_KEY_MENU_ITEMS) : false;

        if ($menuItems === false) {
            $menuItems = [];
            $models = static::find()->where(['isPublished' => true])->orderBy('createTime')->all();
            foreach ($models as $model) {
                $menuItems = self::addItemToTree($menuItems, $model);
            }

            if (Yii::$app->cache) {
                Yii::$app->cache->set(self::CACHE_KEY_MENU_ITEMS, $menuItems);
            }
        }

        return $menuItems;
    }

    public function getRedirectPage() {
        return $this->hasOne(static::className(), ['uid' => 'redirectToUid']);
    }

}

<?php

namespace app\content\models;

use app\content\enums\ContentType;
use app\file\models\ImageMeta;
use app\core\base\AppModel;
use extpoint\yii2\behaviors\TimestampBehavior;
use extpoint\yii2\behaviors\UidBehavior;
use Yii;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;
use yii\db\Query;

/**
 * @property string $type
 * @property string $category
 * @property string $image
 * @property string $previewText
 * @property-read string $imageUrl
 * @property-read string $imageBigUrl
 */
class Content extends BaseContent {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'contents';
    }

    public static function instantiate($row) {
        $className = ContentType::getClassName($row['type']) ?: self::className();
        return new $className;
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return array_merge(parent::rules(), [
            [['type'], 'required'],
            [['type', 'category'], 'string', 'max' => 255],
            [['image', 'previewText'], 'string'],
            ['name', 'unique', 'filter' => function($query) {
                /** @type Query $query */
                $query->andWhere(['type' => $this->type]);
            }],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'uid' => 'UID',
            'type' => 'Тип',
            'category' => 'Категория',
            'image' => 'Картинка',
            'name' => 'Имя латиницей',
            'title' => 'Заголовок',
            'previewText' => 'Анонс',
            'text' => 'Текст',
            'isPublished' => 'Опубликована?',
            'publishTime' => 'Время публикации',
            'createTime' => 'Дата создания',
            'updateTime' => 'Дата редактирования',
        ];
    }

    /**
     * @return string
     */
    public function getImageUrl() {
        return $this->image ? ImageMeta::findByProcessor($this->image)->url : '';
    }

    /**
     * @return string
     */
    public function getImageBigUrl() {
        return /*$this->image ? ImageMeta::findBySize($this->image, 700, 500)->getAbsoluteFileUrl() :*/
            '';
    }

}

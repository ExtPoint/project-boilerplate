<?php

namespace app\content\models;

use app\content\enums\ContentType;
use app\file\models\ImageMeta;
use Yii;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;
use yii\db\Query;

/**
 * @property string $type
 * @property string $category
 * @property string $image
 * @property string $previewText
 * @property string $publishTime
 * @property-read string $imageUrl
 * @property-read string $imageBigUrl
 */
class Article extends BaseContent {

    public static function tableName() {
        return 'content_articles';
    }

    public static function instantiate($row) {
        $className = ContentType::getClassName($row['type']) ?: self::className();
        return new $className();
    }

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return array_merge(parent::behaviors(), [
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_INIT => 'publishTime',
                ],
                'value' => date('Y-m-d H:i')
            ],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return array_merge(parent::rules(), [
            [['type'], 'required'],
            [['type', 'category'], 'string', 'max' => 255],
            [['image', 'previewText'], 'string'],
            ['publishTime', 'string', 'max' => 255], // @todo date
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
        return array_merge(parent::attributeLabels(), [
            'previewText' => \Yii::t('app', 'Анонс'),
            'image' => \Yii::t('app', 'Изображение'),
            'category' => \Yii::t('app', 'Категория'),
            'publishTime' => \Yii::t('app', 'Время публикации'),
        ]);
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

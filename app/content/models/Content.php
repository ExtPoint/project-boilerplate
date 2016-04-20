<?php

namespace app\content\models;

use app\content\enums\ContentType;
use app\file\models\ImageMeta;
use extpoint\yii2\base\AppModel;
use extpoint\yii2\behaviors\TimestampBehavior;
use extpoint\yii2\behaviors\UidBehavior;
use Yii;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;
use yii\db\Query;

/**
 * @property string $uid
 * @property string $creatorUserUid
 * @property string $type
 * @property string $category
 * @property string $image
 * @property string $name
 * @property string $title
 * @property string $previewText
 * @property string $text
 * @property integer $isPublished
 * @property string $publishTime
 * @property string $createTime
 * @property string $updateTime
 * @property-read string $imageUrl
 * @property-read string $imageBigUrl
 */
class Content extends AppModel {

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
    public function behaviors() {
        return [
            UidBehavior::className(),
            TimestampBehavior::className(),
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_INIT => 'isPublished',
                ],
                'value' => true
            ],
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_INIT => 'publishTime',
                ],
                'value' => date('Y-m-d H:i')
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['creatorUserUid', 'title', 'text'], 'required'],
            [['text', 'name'], 'string'],
            ['isPublished', 'boolean'],
            [['uid', 'creatorUserUid'], 'string', 'max' => 36],
            [['type', 'title'], 'string', 'max' => 255],
            ['name', 'unique', 'filter' => function($query) {
                /** @type Query $query */
                $query->andWhere(['type' => $this->type]);
            }],
        ];
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

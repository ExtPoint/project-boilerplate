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
 * @property string $name
 * @property string $title
 * @property string $text
 * @property integer $isPublished
 * @property string $publishTime
 * @property string $createTime
 * @property string $updateTime
 */
abstract class BaseContent extends AppModel {

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
            ['title', 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'uid' => 'UID',
            'name' => 'Имя латиницей',
            'title' => 'Заголовок',
            'text' => 'Текст',
            'isPublished' => 'Опубликована?',
            'publishTime' => 'Время публикации',
            'createTime' => 'Дата создания',
            'updateTime' => 'Дата редактирования',
        ];
    }

}

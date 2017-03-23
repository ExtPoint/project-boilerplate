<?php

namespace app\content\models;

use app\content\validators\ContentNameValidator;
use app\core\base\AppModel;
use app\core\models\User;
use extpoint\yii2\behaviors\TimestampBehavior;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property integer $creatorUserId
 * @property string $name
 * @property string $title
 * @property string $text
 * @property integer $isPublished
 * @property string $createTime
 * @property string $updateTime
 * @property-read User $creator
 */
abstract class BaseContent extends AppModel {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            TimestampBehavior::className(),
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_INIT => 'isPublished',
                ],
                'value' => true
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['creatorUserId', 'title', 'text'], 'required'],
            ['text', 'string'],
            ['name', ContentNameValidator::className()],
            ['isPublished', 'boolean'],
            [['id', 'creatorUserId'], 'string', 'max' => 36],
            ['title', 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => \Yii::t('app', 'ID'),
            'name' => \Yii::t('app', 'Имя латиницей'),
            'title' => \Yii::t('app', 'Заголовок'),
            'text' => \Yii::t('app', 'Текст'),
            'isPublished' => \Yii::t('app', 'Опубликована?'),
            'createTime' => \Yii::t('app', 'Дата создания'),
            'updateTime' => \Yii::t('app', 'Дата редактирования'),
        ];
    }

    public function getCreator() {
        return $this->hasOne(User::className(), ['id' => 'creatorUserId']);
    }

}

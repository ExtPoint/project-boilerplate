<?php

namespace app\content\models;

use app\content\validators\ContentNameValidator;
use app\core\base\AppModel;
use app\core\models\User;
use extpoint\yii2\behaviors\TimestampBehavior;
use extpoint\yii2\behaviors\UidBehavior;
use Yii;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;

/**
 * @property string $uid
 * @property string $creatorUserUid
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
            UidBehavior::className(),
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
            [['creatorUserUid', 'title', 'text'], 'required'],
            ['text', 'string'],
            ['name', ContentNameValidator::className()],
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
            'uid' => \Yii::t('app', 'UID'),
            'name' => \Yii::t('app', 'Имя латиницей'),
            'title' => \Yii::t('app', 'Заголовок'),
            'text' => \Yii::t('app', 'Текст'),
            'isPublished' => \Yii::t('app', 'Опубликована?'),
            'createTime' => \Yii::t('app', 'Дата создания'),
            'updateTime' => \Yii::t('app', 'Дата редактирования'),
        ];
    }

    public function getCreator() {
        return $this->hasOne(User::className(), ['uid' => 'creatorUserUid']);
    }

}

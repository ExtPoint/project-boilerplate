<?php

namespace app\dictionary\models;
use extpoint\yii2\behaviors\TimestampBehavior;

use Yii;

/**
 * This is the model class for table "dictionary".
 *
 * @property string $type
 * @property string $name
 * @property string $title
 * @property string $createTime
 * @property string $updateTime
 */
class Dictionary extends \app\core\base\AppModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dictionary';
    }

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'name'], 'required'],
            [['createTime', 'updateTime'], 'safe'],
            [['type', 'name', 'title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'type' => 'Тип',
            'name' => 'Имя латиницей',
            'title' => 'Заголовок',
            'createTime' => 'Дата создания',
            'updateTime' => 'Дата редактирования',
        ];
    }

    public static function getLabels($type) {
        $models = self::find()->where(['type' => $type])->all();
        $items = [];
        foreach($models as $model) {
            $items[$model->name] = $model->title;
        }
        return $items;
    }

    public static function getKeys($type) {
        $models = self::find()->where(['type' => $type])->all();
        return array_map(function ($model) {
            return $model->name;
        }, $models);
    }

    public static function getLabel($type, $name) {
        $model = self::find()->where(['type' => $type, 'name' => $name])->one();
        return $model ? $model->title : null;
    }
}

<?php

namespace app\auth\models;

use app\core\models\User;
use \app\core\base\AppModel;

/**
 *
 * @property integer $id
 * @property integer $userId
 * @property string $source
 * @property integer $sourceId
 * @property-read User $user
 */
class SocialConnection extends AppModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'auth_social_connections';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['source', 'sourceId'], 'required'],
            ['userId', 'integer'],
            [['source', 'sourceId'], 'string', 'max' => 256],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'userId' => 'User id',
            'source' => 'source',
            'sourceId' => 'source ID',
        ];
    }

    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'userId']);
    }
}

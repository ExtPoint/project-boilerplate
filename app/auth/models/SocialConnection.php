<?php

namespace app\auth\models;

use app\core\models\User;
use \app\core\base\AppModel;

/**
 *
 * @property string $uid
 * @property string $userUid
 * @property string $source
 * @property string $sourceId
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
            [['userUid'], 'string', 'max' => 36],
            [['source', 'sourceId'], 'string', 'max' => 256],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'userUid' => 'User Uid',
            'source' => 'source',
            'sourceId' => 'source ID',
        ];
    }

    public function getUser() {
        return $this->hasOne(User::className(), ['uid' => 'userUid']);
    }
}

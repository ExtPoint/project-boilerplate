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
            [['userUid'], 'required'],
            [['userUid'], 'string', 'max' => 36],
            [['service', 'service_id'], 'string', 'max' => 256],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'userUid' => 'User Uid',
            'service' => 'Service',
            'service_id' => 'Service ID',
        ];
    }

    public function getUser() {
        return $this->hasOne(User::className(), ['uid' => 'userUid']);
    }
}

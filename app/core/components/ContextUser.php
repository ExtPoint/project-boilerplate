<?php

namespace app\core\components;

use yii\web\User;

/**
 * Class ContextUser
 * @property \app\core\models\User $model
 * @property string $uid
 * @package app\core\components
 */
class ContextUser extends User {

    /**
     * @return \app\core\models\User
     */
    public function getModel() {
        return $this->identity;
    }

    /**
     * @return string
     */
    public function getUid() {
        return $this->getModel() ? $this->getModel()->uid : null;
    }

    public function can($permissionName, $params = [], $allowCaching = true)
    {
        return !$this->getIsGuest() && $this->getModel() && (
            $this->getModel()->role === \app\core\models\User::ROLE_ADMIN
            || $this->getModel()->role === $permissionName
        );
    }

}
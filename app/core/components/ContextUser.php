<?php

namespace app\core\components;

use app\profile\enums\UserRole;
use yii\web\User;

/**
 * Class ContextUser
 * @property \app\profile\models\User $model
 * @property string $uid
 * @package app\core\components
 */
class ContextUser extends User {

    /**
     * @return \app\profile\models\User
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
            $this->getModel()->role === UserRole::ADMIN
            || $this->getModel()->role === $permissionName
        );
    }

}
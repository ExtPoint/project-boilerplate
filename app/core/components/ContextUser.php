<?php

namespace app\core\components;

use app\profile\enums\UserRole;
use yii\web\User;

/**
 * Class ContextUser
 * @property-read \app\core\models\User $model
 * @property-read string $uid
 * @property-read string $name
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
     * @return string|null
     */
    public function getUid() {
        return $this->getModel() ? $this->getModel()->uid : null;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->getModel() ? $this->getModel()->name : '';
    }

    public function can($permissionName, $params = [], $allowCaching = true)
    {
        return !$this->getIsGuest() && $this->getModel() && (
            $this->getModel()->role === UserRole::ADMIN
            || $this->getModel()->role === $permissionName
        );
    }

}
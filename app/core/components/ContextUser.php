<?php

namespace app\core\components;

use app\profile\enums\UserRole;
use yii\helpers\Url;
use yii\web\User;

/**
 * Class ContextUser
 * @property-read \app\core\models\User $model
 * @property-read string $uid
 * @property-read string $name
 * @package app\core\components
 */
class ContextUser extends User {

    private $_overrideIdentity = null;

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

    // TODO: Add redirects by POST field, but protect against redirects outside of the current domain by user input
    public function getReturnUrl($defaultUrl = null)
    {
        $url = \Yii::$app->getSession()->get($this->returnUrlParam, $defaultUrl);
        if (is_array($url)) {
            if (isset($url[0])) {
                return Url::to($url);
            } else {
                $url = null;
            }
        }

        return $url === null ? \Yii::$app->getHomeUrl() : $url;
    }

    public function getIdentity($autoRenew = true)
    {
        if ($this->_overrideIdentity !== null) {
            return $this->_overrideIdentity;
        }

        return parent::getIdentity($autoRenew);
    }

    public function setIdentity($identity) {

        // Allows use in console
        if (!\Yii::$app->hasProperty('request')) {
            $this->_overrideIdentity = $identity;
        }
        else {
            parent::setIdentity($identity);
        }

        // @todo Wrong place for update app config, it's code running only on call user component.
        // Configure localization
        /*if (!\Yii::$app->user->isGuest) {
            \Yii::$app->formatter->locale = \Yii::$app->user->model->locale;
            \Yii::$app->formatter->timeZone = \Yii::$app->user->model->timeZone;
        }*/

        // Expose detail exceptions to support accounts always
        /*if ($identity && $identity->getId() === USER_EXTPOINT_SUPPORT) {
            Yii::$app->errorHandler->errorView = Yii::$app->errorHandler->exceptionView;
        }*/
    }

}
<?php

namespace app\core\components;

use app\core\models\User;
use yii\filters\AccessRule;

class ViewedUserRule extends AccessRule {

    public $requestKey = 'userUid';

    /**
     * @param \yii\base\Action $action
     * @param ContextUser $user
     * @param \yii\web\Request $request
     * @return bool
     */
    public function allows($action, $user, $request) {
        if ($user->can(User::ROLE_ADMIN)) {
            return true;
        }
        return $user->can(User::ROLE_USER) && $user->model->uid == $request->get($this->requestKey);
    }

}
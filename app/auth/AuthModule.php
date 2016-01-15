<?php

namespace app\auth;

use app\core\base\AppModule;

class AuthModule extends AppModule {

    protected function coreUrlRules() {
        return [
            'login/recovery/captcha' => 'auth/recovery/captcha',
            'login/recovery/<code>' => 'auth/recovery/code',
            'login/recovery' => 'auth/auth/index',
            'registration/agreement' => 'auth/auth/agreement',
            '<action:(login|registration|logout)' => 'auth/auth/<action>',
        ];
    }

}

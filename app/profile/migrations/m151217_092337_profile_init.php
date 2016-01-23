<?php

use yii\db\Schema;
use yii\db\Migration;

class m151217_092337_profile_init extends Migration {
    public function up() {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('users', [
            'uid' => $this->string(36)->notNull(),
            'email' => $this->string(255),
            'name' => $this->string(255),
            'role' => $this->string(32)->notNull(),
            'photo' => $this->string(),
            'password' => $this->string(32),
            'salt' => $this->string(10),
            'authKey' => $this->string(32),
            'accessToken' => $this->string(32),
            'recoveryKey' => $this->string(32),
            'createTime' => $this->dateTime()->notNull(),
            'updateTime' => $this->dateTime()->notNull(),
        ], $tableOptions);
        $this->addPrimaryKey('uid', 'users', 'uid');

        $this->createTable('users_info', [
            'userUid' => $this->string(36),
            'firstName' => $this->string(),
            'lastName' => $this->string(),
            'birthday' => $this->date(),
            'phone' => $this->string(),
        ], $tableOptions);
        $this->addPrimaryKey('userUid', 'users_info', 'userUid');

        // Prompt admin email
        $email = YII_DEBUG ? Yii::$app->controller->prompt('Please write you email (as administrator, password: 1):') : '';
        $email = $email ?: 'admin@boilerplate-yii2-k4nuj8';

        // Add administrator
        $user = new \app\core\models\User();
        $user->email = $email;
        $user->name = 'Администратор';
        $user->password = $user->passwordToHash('1');
        $user->role = \app\profile\enums\UserRole::ADMIN;
        $user->saveOrPanic();
    }

    public function down() {
        $this->dropTable('users');
        $this->dropTable('users_info');
    }
}

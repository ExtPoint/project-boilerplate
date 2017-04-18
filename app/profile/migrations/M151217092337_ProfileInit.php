<?php

namespace app\profile\migrations;

use Yii;
use extpoint\yii2\base\Migration;

class M151217092337_ProfileInit extends Migration
{
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('users', [
            'id' => $this->primaryKey(),
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
            'firstName' => $this->string(),
            'lastName' => $this->string(),
            'birthday' => $this->date(),
            'phone' => $this->string(),
        ], $tableOptions);

        // Prompt admin email
        $email = YII_DEBUG ? Yii::$app->controller->prompt('Please write you email (as administrator, password: 1):') : '';
        $email = $email ?: 'admin@boilerplate-yii2-k4nuj8';

        $user = new \app\core\models\User();
        $user->password = $user->passwordToHash('1');

        // Add administrator
        Yii::$app->db->createCommand()
            ->insert('users', [
                'email' => $email,
                'name' => 'Администратор',
                'salt' => $user->salt,
                'password' => $user->password,
                'role' => \app\profile\enums\UserRole::ADMIN,
                'createTime' => date('Y-m-d H:i:s'),
                'updateTime' => date('Y-m-d H:i:s'),
            ])
            ->execute();
    }

    public function down()
    {
        $this->dropTable('users');
    }
}

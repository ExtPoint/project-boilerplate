<?php

namespace app\profile\admin\forms;

use app\core\models\User;
use app\core\traits\SearchModelTrait;
use yii\db\ActiveQuery;

class UserSearch extends User
{
    use SearchModelTrait;

    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['email', 'name', 'role', 'photo', 'password', 'salt', 'authKey', 'accessToken', 'recoveryKey', 'createTime', 'updateTime', 'firstName', 'lastName', 'birthday', 'phone'], 'safe'],
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function createQuery()
    {
        return User::find();
    }

    /**
     * @return array
     */
    public function createProvider()
    {
        return [
            'sort' => [
                'attributes' => ['id'],
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ],
            ],
            'pagination' => [
                'pageSize' => 50,
            ],
        ];
    }

    /**
     * @param ActiveQuery $query
     */
    public function prepare($query)
    {
        $query->andFilterWhere([
            'id' => $this->id,
            'createTime' => $this->createTime,
            'updateTime' => $this->updateTime,
            'birthday' => $this->birthday,
        ]);

        $query->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'role', $this->role])
            ->andFilterWhere(['like', 'photo', $this->photo])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'salt', $this->salt])
            ->andFilterWhere(['like', 'authKey', $this->authKey])
            ->andFilterWhere(['like', 'accessToken', $this->accessToken])
            ->andFilterWhere(['like', 'recoveryKey', $this->recoveryKey])
            ->andFilterWhere(['like', 'firstName', $this->firstName])
            ->andFilterWhere(['like', 'lastName', $this->lastName])
            ->andFilterWhere(['like', 'phone', $this->phone]);
    }

}

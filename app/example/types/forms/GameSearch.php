<?php

namespace app\example\types\forms;

use app\example\types\models\Game;
use app\core\traits\SearchModelTrait;
use yii\db\ActiveQuery;

class GameSearch extends Game
{
    use SearchModelTrait;

    public function rules()
    {
        return [
            [['id', 'rating', 'isDisabled', 'logoId', 'winExeId', 'macDmgId', 'creatorId'], 'integer'],
            [['createTime', 'updateTime', 'title', 'shortDescription', 'fullDescription', 'tillDate'], 'safe'],
            [['price'], 'number'],
        ];
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
            'rating' => $this->rating,
            'isDisabled' => $this->isDisabled,
            'price' => $this->price,
            'tillDate' => $this->tillDate,
            'logoId' => $this->logoId,
            'winExeId' => $this->winExeId,
            'macDmgId' => $this->macDmgId,
            'creatorId' => $this->creatorId,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'shortDescription', $this->shortDescription])
            ->andFilterWhere(['like', 'fullDescription', $this->fullDescription]);
    }

}

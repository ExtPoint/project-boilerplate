<?php

namespace app\core\traits;

use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

trait SearchModelTrait {

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = $this->create();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $this->prepare($query);

        return $dataProvider;
    }

    /**
     * @type ActiveQuery
     */
    public function create() {
        return static::find();
    }

    public function prepare($query) {

    }

}

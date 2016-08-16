<?php

namespace app\core\traits;

use yii\data\ActiveDataProvider;

trait SearchModelTrait {

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = static::find();

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

    protected function prepare($query) {

    }

}

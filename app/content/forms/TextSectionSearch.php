<?php

namespace app\content\forms;

use app\content\models\TextSection;
use Yii;
use yii\data\ActiveDataProvider;

class TextSectionSearch extends TextSection {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'title'], 'safe'],
        ];
    }

    public function search($params) {
        $this->load($params);

        $query = static::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query
            ->orderBy(['createTime' => SORT_DESC])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }

}

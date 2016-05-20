<?php

namespace app\dictionary\forms;

use Yii;
use yii\db\Query;
use app\core\traits\SearchModelTrait;
use app\dictionary\models\Dictionary;

class DictionarySearch extends Dictionary {

    use SearchModelTrait;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['type', 'name', 'title', 'createTime', 'updateTime'], 'safe'],
        ];
    }

    /**
     * @param Query $query
     */
    protected function prepare($query) {
        $query->andFilterWhere([
            'createTime' => $this->createTime,
            'updateTime' => $this->updateTime,
        ]);

        $query->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'title', $this->title]);
    }

}

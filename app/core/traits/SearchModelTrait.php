<?php

namespace app\core\traits;

use extpoint\yii2\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\db\BaseActiveRecord;
use yii\helpers\ArrayHelper;

trait SearchModelTrait
{
    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params = [])
    {
        $query = $this->createQuery();

        $dataProvider = $this->createProvider();
        if (is_array($dataProvider)) {
            $dataProvider = new ActiveDataProvider(ArrayHelper::merge(
                $dataProvider,
                [
                    'query' => $query,
                ]
            ));
        } else if ($dataProvider instanceof ActiveDataProvider) {
            $dataProvider->query = $query;
        }

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $this->prepare($query);

        return $dataProvider;
    }

    /**
     * @return ActiveQuery
     */
    public function createQuery()
    {
        /** @var Model $className */
        $className = get_parent_class(static::className());
        return $className instanceof BaseActiveRecord ? $className::find() : null;
    }

    /**
     * @return ActiveDataProvider|array
     */
    public function createProvider()
    {
        return [];
    }

    /**
     * @param ActiveQuery $query
     */
    public function prepare($query)
    {

    }

}

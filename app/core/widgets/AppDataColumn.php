<?php

namespace app\core\widgets;

use extpoint\yii2\base\Model;
use yii\bootstrap\ActiveField;
use yii\grid\DataColumn;

class AppDataColumn extends DataColumn
{
    protected function renderFilterCellContent()
    {
        $model = $this->grid->filterModel;
        if ($this->filter === null && $this->attribute && $model instanceof Model) {
            $item = $model::meta()[$this->attribute];
            if (empty($item['showInFilter'])) {
                return $this->grid->emptyCell;
            }

            $appType = \Yii::$app->types->getType(!empty($item['appType']) ? $item['appType'] : 'string');
            return $appType->renderSearchField($model, $this->attribute, $item);
        }

        return parent::renderFilterCellContent();
    }

    protected function renderDataCellContent($model, $key, $index)
    {
        if ($this->content === null && $this->value === null && $this->format === 'text' && $this->attribute && $model instanceof Model) {
            $item = $model::meta()[$this->attribute];
            $appType = \Yii::$app->types->getType(!empty($item['appType']) ? $item['appType'] : 'string');
            return $appType->renderForTable($model, $this->attribute, $item, $this->options);
        }

        return parent::renderDataCellContent($model, $this->attribute, $index);
    }
}
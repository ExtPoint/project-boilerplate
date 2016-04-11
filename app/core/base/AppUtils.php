<?php

namespace app\core\base;

use extpoint\yii2\Utils;

/**
 * @package app\core\base
 */
class AppUtils extends Utils {

    const OLDER_THAN_EVERYTHING = '2000-01-01';

    /**
     * @param AppModel[] $models
     * @param callable|null $filterModelFn
     * @return array
     */
    public static function buildTree($models, $filterModelFn = null) {

        $result = [];
        $all = [];

        foreach ($models as $model) {
            $id = $model->id;
            $parentId = $model->parentId ?: 0;
            $all[$id]['model'] = $filterModelFn ? $filterModelFn($model) : $model;
            $all[$parentId]['children'][] = &$all[$id];
            if (!$parentId) {
                $result[] = &$all[$id];
            }
        }

        return $result;
    }

    /**
     * @param array[] $entries Tree from self::buildTree()
     * @param mixed[]|null $whiteIds
     * @param int $level
     * @return array[]
     */
    public static function filterAndFlatten($entries, $whiteIds = null, $level = 0) {

        $result = [];

        foreach ($entries as $entry) {
            if (!empty($entry['children'])) {
                $entry['children'] = self::filterAndFlatten($entry['children'], $whiteIds, $level + 1);
            }
            if (!empty($entry['children']) || $whiteIds === null || isset($whiteIds[$entry['model']->id])) {
                $entry['level'] = $level;
                $result[] = $entry;
                if (!empty($entry['children'])) {

                    $result = array_merge($result, $entry['children']);
                }
            }
        }

        return $result;
    }

}
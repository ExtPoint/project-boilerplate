<?php

namespace app\gii\admin\generators\model;

use app\gii\admin\helpers\GiiHelper;
use yii\gii\CodeFile;
use yii\gii\Generator;
use yii\helpers\ArrayHelper;

class ModelGenerator extends Generator
{
    public $moduleId;
    public $modelName;
    public $tableName;
    public $meta = [];
    public $relations = [];

    public function getName() {
        return 'model';
    }

    public function requiredTemplates()
    {
        return ['meta', 'migrationCreate', 'migrationUpdate'];
    }

    /**
     * @inheritdoc
     */
    public function generate()
    {
        $moduleDir = \Yii::getAlias('@app') . '/' . str_replace('.', '/', $this->moduleId);

        // Create/update meta information
        (new CodeFile(
            $moduleDir . '/models/meta/' . ucfirst($this->modelName) . 'Meta.php',
            $this->render('meta.php', [
                'namespace' => 'app\\' . str_replace('.', '\\', $this->moduleId) . '\\models\\meta',
                'className' =>  ucfirst($this->modelName) . 'Meta',
                'tableName' => $this->tableName,
                'meta' => $this->meta,
                'relations' => array_map(function($relation) {
                    $relation['model'] = GiiHelper::getModelByClass($relation['relationModelClassName']);
                    return $relation;
                }, $this->relations),
            ])
        ))->save();
        \Yii::$app->session->addFlash('success', 'Мета информция модели ' . ucfirst($this->modelName) . ' обновлена');

        // Create model, if not exists
        $modelFilePath = $moduleDir . '/models/' . ucfirst($this->modelName) . '.php';
        if (!file_exists($modelFilePath)) {
            (new CodeFile(
                $moduleDir . '/models/' . ucfirst($this->modelName) . '2.php',
                $this->render('model.php', [
                    'namespace' => 'app\\' . str_replace('.', '\\', $this->moduleId) . '\\models',
                    'className' =>  ucfirst($this->modelName),
                    'tableName' => $this->tableName,
                    'meta' => $this->meta,
                ])
            ))->save();
            \Yii::$app->session->addFlash('success', 'Добавлена модель ' . ucfirst($this->modelName));
        }

        // Create migration
        $tablesToCreate = [];
        $addColumn = [];
        $alterColumn = [];
        $alterColumnDown = [];
        $dropColumn = [];

        // Create table in migration
        $oldModel = GiiHelper::getModel($this->moduleId, $this->modelName);
        $oldMeta = $oldModel ? ArrayHelper::index($oldModel['meta'], 'name') : null;
        if (!$oldMeta) {
            $columns = [];
            foreach ($this->meta as $item) {
                $columns[$item['name']] = $this->getColumnType($item);
            }
            $tablesToCreate[] = [
                'table' => $this->tableName,
                'columns' => $columns,
            ];
        } else {
            // Find changes
            foreach ($this->meta as $item) {
                if (!isset($oldMeta[$item['name']])) {
                    $addColumn[] = $item;
                } else if ($this->getColumnType($item) !== $this->getColumnType($oldMeta[$item['name']])) {
                    $alterColumn[] = $item;
                    $alterColumnDown[] = $oldMeta[$item['name']];
                }
            }

            $metaNames = ArrayHelper::getColumn($this->meta, 'name');
            foreach ($oldMeta as $oldItem) {
                if (!in_array($oldItem['name'], $metaNames)) {
                    $dropColumn[] = $oldItem;
                }
            }
        }

        // Junction table in migration
        foreach ($this->relations as $relation) {
            if (!empty($relation['viaTable']) && \Yii::$app->db->getTableSchema($relation['viaTable']) === null) {
                $relationModel = GiiHelper::getModelByClass($relation['relationModelClassName']);
                $relationKeyType = isset($relationModel['meta'][$relation['viaRelationKey']]) && !empty($relationModel['meta'][$relation['viaRelationKey']]['dbType'])
                    ? $relationModel['meta'][$relation['viaRelationKey']]['dbType']
                    : 'integer';
                $selfKeyType = isset($this->meta[$relation['viaSelfKey']]) && !empty($this->meta[$relation['viaSelfKey']]['dbType'])
                    ? $this->meta[$relation['viaSelfKey']]['dbType']
                    : 'integer';

                $tablesToCreate[] = [
                    'table' => $relation['viaTable'],
                    'columns' => [
                        $relation['viaRelationKey'] => $relationKeyType . ' NOT NULL',
                        $relation['viaSelfKey'] => $selfKeyType . ' NOT NULL',
                    ],
                ];
            }
        }

        // Foreign keys
        foreach ($this->relations as $relation) {
            
        }

        // Create migration
        if (!empty($addColumn) ||!empty($alterColumn) ||!empty($dropColumn) ||!empty($tablesToCreate)) {
            $migrationClassName = 'm' . gmdate('ymd_His') . '_upd_' . $this->tableName;
            (new CodeFile(
                $moduleDir . '/migrations/' . $migrationClassName . '.php',
                $this->render('migration.php', [
                    'className' => $migrationClassName,
                    'tableName' => $this->tableName,
                    'meta' => $this->meta,
                    'addColumn' => $addColumn,
                    'alterColumn' => $alterColumn,
                    'alterColumnDown' => $alterColumnDown,
                    'dropColumn' => $dropColumn,
                    'tablesToCreate' => $tablesToCreate,
                ])
            ))->save();
            \Yii::$app->session->addFlash('success', 'Добавлена миграция ' . $migrationClassName);
        }

    }

    /**
     * @param $dbType
     * @return string
     */
    public function getPhpDocType($dbType)
    {
        static $typeMap = [
            'bigint' => 'integer',
            'integer' => 'integer',
            'smallint' => 'integer',
            'boolean' => 'boolean',
            'float' => 'double',
            'double' => 'double',
            'binary' => 'resource',
        ];
        return isset($typeMap[$dbType]) ? $typeMap[$dbType] : 'string';
    }

    public function exportMeta($indent = '') {
        $meta = [];
        foreach ($this->meta as $metaItem) {
            $meta[$metaItem['name']] = [];
            foreach ($metaItem as $key => $value) {
                if ($key !== 'name' && $value !== '') {
                    $meta[$metaItem['name']][$key] = $value;
                }
            }
        }
        return GiiHelper::varExport($meta, $indent);
    }

    public function getColumnType($item) {
        return (!empty($item['dbType']) ? $item['dbType'] : 'string') . (!empty($item['notNull']) ? ' NOT NULL' : '');
    }

    public function exportRules() {
        $generator = new \yii\gii\generators\model\Generator();
        return $generator->generateRules(\Yii::$app->db->getTableSchema($this->tableName));
    }

}
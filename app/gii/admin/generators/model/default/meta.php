<?php

namespace app\views;

use app\gii\admin\generators\model\ModelGenerator;
use app\gii\admin\helpers\GiiHelper;
use yii\helpers\ArrayHelper;
use yii\web\View;

/* @var $this View */
/* @var $generator ModelGenerator */
/* @var $tableName string */
/* @var $namespace string */
/* @var $className string */
/* @var $meta array */
/* @var $relations array */

echo "<?php\n";
?>

namespace <?= $namespace ?>;

use app\core\base\AppModel;
<?php if (count($relations) > 0) { ?>
use yii\db\ActiveQuery;
<?php } ?>
<?php foreach (array_unique(ArrayHelper::getColumn($relations, 'relationModelClassName')) as $relationClassName) { ?>
use <?= $relationClassName ?>;
<?php } ?>

/**
<?php foreach ($meta as $metaItem) { ?>
 * @property <?= "{$generator->getPhpDocType($metaItem['dbType'])} \${$metaItem['name']}\n" ?>
<?php } ?>
<?php foreach ($relations as $relation) { ?>
 * @property-read <?= $relation['model']['name'] ?> <?= "\${$relation['name']}\n" ?>
<?php } ?>
 */
abstract class <?= $className ?> extends AppModel
{
    public static function tableName()
    {
        return '<?= $tableName ?>';
    }
<?php foreach ($relations as $relation) { ?>

    /**
     * @return ActiveQuery
     */
    public function get<?= ucfirst($relation['name']) ?>()
    {
<?php if ($relation['type'] !== 'manyToMany') { ?>
        return $this-><?= $relation['type'] === 'hasOne' ? 'hasOne' : 'hasMany' ?>(<?= $relation['model']['name'] ?>::className(), ['<?= $relation['relationKey'] ?>' => '<?= $relation['selfKey'] ?>']);
<?php } else { ?>
        return $this->hasMany(<?= $relation['model']['name'] ?>::className(), ['<?= $relation['relationKey'] ?>' => '<?= $relation['viaRelationKey'] ?>'])
            ->viaTable('<?= $relation['viaTable'] ?>', ['<?= $relation['viaSelfKey'] ?>' => '<?= $relation['selfKey'] ?>']);
<?php } ?>
    }
<?php } ?>

    public static function meta()
    {
        return <?= $generator->exportMeta('        ') ?>;
    }
}

<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */


$modelClass = StringHelper::basename($generator->modelClass);
$modelVar = '$' . lcfirst($modelClass);

echo "<?php\n";
?>

namespace app\views;

use <?= ltrim($generator->modelClass, '\\') ?>;
use Yii;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;

/* @var View $this */
/* @var <?= $modelClass ?> <?= $modelVar ?> */

?>

<h1><?= "<?= " ?>Html::encode($this->title) ?></h1>

<?= "<?= " ?>DetailView::widget([
    'model' => <?= $modelVar ?>,
    'attributes' => [
<?php
if (($tableSchema = $generator->getTableSchema()) === false) {
foreach ($generator->getColumnNames() as $name) {
    echo "            '" . $name . "',\n";
}
} else {
foreach ($generator->getTableSchema()->columns as $column) {
    $format = $generator->generateColumnFormat($column);
    echo "        '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
}
}
?>
    ],
]) ?>

<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$nameAttribute = $generator->getNameAttribute();

$modelClass = StringHelper::basename($generator->modelClass);
$modelVar = '$' . lcfirst($modelClass);
$searchModelVarName = lcfirst($modelClass) . 'SearchModel';

echo "<?php\n";
?>

namespace app\views;

use Yii;
use yii\web\View;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use <?= $generator->searchModelClass ?>;

/* @var View $this */
<?= !empty($generator->searchModelClass) ? "/* @var " . StringHelper::basename($generator->searchModelClass) . " $" . $searchModelVarName . " */\n" : '' ?>
/* @var ActiveDataProvider $dataProvider */

?>

<h1><?= "<?= " ?>Html::encode($this->title) ?></h1>
<p>
    <?= "<?= " ?>Html::a(<?= $generator->generateString('Добавить') ?>, ['update'], ['class' => 'btn btn-success']) ?>
</p>

<?= "<?= " ?>GridView::widget([
    'dataProvider' => $dataProvider,
    <?= !empty($generator->searchModelClass) ? "'filterModel' => $" . $searchModelVarName . ",\n    'columns' => [\n" : "'columns' => [\n"; ?>
        ['class' => 'yii\grid\SerialColumn'],

<?php
    foreach (array_values($generator->getTableSchema()->columns) as $i => $column) {
        $format = $generator->generateColumnFormat($column);
        echo "        " . ($i < 6 ? '' : '//') . "'" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
    }
?>

        ['class' => 'yii\grid\ActionColumn'],
    ],
]); ?>

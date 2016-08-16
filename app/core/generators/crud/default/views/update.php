<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */


$modelClass = StringHelper::basename($generator->modelClass);
$modelVar = '$' . lcfirst($modelClass) . 'Model';

$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}

echo "<?php\n";
?>

namespace app\views;

use Yii;
use yii\web\View;
use yii\helpers\Html;
use app\core\widgets\AppActiveForm;
use <?= ltrim($generator->modelClass, '\\') ?>;

/* @var View $this */
/* @var <?= $modelClass ?> <?= $modelVar ?> */

?>

<h1><?= "<?= " ?>Html::encode($this->title) ?></h1>

<?= "<?php " ?>$form = AppActiveForm::begin(); ?>

<?php foreach ($generator->getColumnNames() as $attribute) {
    if (in_array($attribute, $safeAttributes)) {
        echo "    <?= " . str_replace('$model', $modelVar, $generator->generateActiveField($attribute)) . " ?>\n";
    }
} ?>

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-6">
            <?= "<?= " ?>Html::submitButton(<?= $modelVar ?>->isNewRecord ? <?= $generator->generateString('Добавить') ?> : <?= $generator->generateString('Сохранить') ?>, ['class' => 'btn btn-success']) ?>
        </div>
    </div>

<?= "<?php " ?>AppActiveForm::end(); ?>

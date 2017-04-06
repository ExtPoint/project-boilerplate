<?php

namespace app\views;

use app\gii\admin\generators\model\ModelGenerator;
use yii\web\View;

/* @var $this View */
/* @var $generator ModelGenerator */
/* @var $tableName string */
/* @var $namespace string */
/* @var $className string */
/* @var $meta array */

echo "<?php\n";
?>

namespace <?= $namespace ?>;

use <?= $namespace ?>\meta\<?= $className ?>Meta;

class <?= $className ?> extends <?= $className ?>Meta
{
    public function rules()
    {
        return [<?= "\n            " . implode(",\n            ", $generator->exportRules()) . ",\n        " ?>];
    }
}

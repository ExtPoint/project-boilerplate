<?php

namespace app\views;

use app\gii\admin\generators\crud\CrudGenerator;
use yii\web\View;

/* @var $this View */
/* @var $generator CrudGenerator */
/* @var $namespace string */
/* @var $className string */

echo "<?php\n";
?>

namespace <?= $namespace ?>;

use app\core\base\admin\AppAdminModule;

class <?= $className ?> extends AppAdminModule
{
    public function coreMenu()
    {
        return [
            'admin' => [
                'items' => [],
            ],
        ];
    }
}
<?php

use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator \app\core\generators\crud\CrudGenerator */

$modelClass = StringHelper::basename($generator->modelClass);
$searchModelClass = StringHelper::basename($generator->getSearchModelClass());
$searchConditions = $generator->generateSearchConditions();

echo "<?php\n";
?>

namespace <?= StringHelper::dirname(ltrim($generator->getSearchModelClass(), '\\')) ?>;

use Yii;
use yii\db\Query;
use app\core\traits\SearchModelTrait;
use <?= ltrim($generator->modelClass, '\\') ?>;

class <?= $searchModelClass ?> extends <?= $modelClass ?> {

    use SearchModelTrait;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            <?= implode(",\n            ", $generator->generateSearchRules()) ?>,
        ];
    }

    /**
     * @param Query $query
     */
    protected function prepare($query) {
        <?= implode("\n        ", $searchConditions) ?>
    }

}

<?php

use yii\helpers\StringHelper;


/* @var $this yii\web\View */
/* @var $generator \app\core\generators\crud\CrudGenerator */

$controllerClass = StringHelper::basename($generator->controllerClass);
$modelClass = StringHelper::basename($generator->modelClass);
$searchModelClass = StringHelper::basename($generator->searchModelClass);
$actionParams = $generator->generateActionParams();
$actionParamComments = $generator->generateActionParamComments();
$modelVarName = lcfirst($modelClass) . 'Model';
$searchModelVarName = lcfirst($modelClass) . 'SearchModel';

echo "<?php\n";
?>
namespace <?= StringHelper::dirname(ltrim($generator->controllerClass, '\\')) ?>;

use Yii;
use <?= ltrim($generator->modelClass, '\\') ?>;
use <?= ltrim($generator->searchModelClass, '\\') ?>;
use app\core\base\AppController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\profile\enums\UserRole;

class <?= $controllerClass ?> extends AppController {

    public static function coreMenus($urlPrefix = 'admin/<?= $generator->modelId ?>') {
        array_merge([
            'type' => \Yii::$app->request instanceof Request ? \Yii::$app->request->get('type') : null,
            'name' => \Yii::$app->request instanceof Request ? \Yii::$app->request->get('name') : null,
        ], $actionParams);

        return [
            'label' => '<?= $generator->modelName ?>',
            'url' => ["/<?= $generator->moduleId ?>/<?= $generator->controllerId ?>/index"],
            'items' => [
                [
                    'label' => '<?= $generator->modelName ?>',
                    'url' => ["/<?= $generator->moduleId ?>/<?= $generator->controllerId ?>/index"],
                    'urlRule' => $urlPrefix,
                ],
                [
                    'label' => 'Добавление',
                    'url' => ["/<?= $generator->moduleId ?>/<?= $generator->controllerId ?>/update"],
                    'urlRule' => "$urlPrefix/create",
                ],
                [
                    'label' => 'Редактирование',
                    'url' => ["/<?= $generator->moduleId ?>/<?= $generator->controllerId ?>/update", '<?= implode('\' => null, \'', $actionParams) ?>' => null],
                    'urlRule' => "$urlPrefix/update/<<?= implode('>/<', $actionParams) ?>>",
                ],
                [
                    'label' => 'Просмотр',
                    'url' => ["/<?= $generator->moduleId ?>/<?= $generator->controllerId ?>/view", '<?= implode('\' => null, \'', $actionParams) ?>' => null],
                    'urlRule' => "$urlPrefix/view/<<?= implode('>/<', $actionParams) ?>>",
                ],
            ],
        ];
    }

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [UserRole::ADMIN],
                    ],
                ],
            ],
        ];
    }

    /**
     * @return mixed
     */
    public function actionIndex() {
        $<?= $searchModelVarName ?> = new <?= $searchModelClass ?>();
        $dataProvider = $<?= $searchModelVarName ?>->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            '<?= $searchModelVarName ?>' => $<?= $searchModelVarName ?>,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return mixed
     */
    public function actionView($<?= implode(', $', $actionParams) ?>) {
        return $this->render('view', [
            '<?= $modelVarName ?>' => $this->findModel($<?= implode(', $', $actionParams) ?>),
        ]);
    }

    /**
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return mixed
     */
    public function actionUpdate($<?= implode(' = null, $', $actionParams) ?> = null) {
        $<?= $modelVarName ?> = $<?= implode(' && $', $actionParams) ?> ? $this->findModel($<?= implode(', $', $actionParams) ?>) : new <?= $modelClass ?>();

        if ($<?= $modelVarName ?>->load(Yii::$app->request->post()) && $<?= $modelVarName ?>->save()) {
            return $this->redirect(['index']);
        }
        return $this->render('update', [
            '<?= $modelVarName ?>' => $<?= $modelVarName ?>,
        ]);
    }

    /**
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return mixed
     */
    public function actionDelete($<?= implode(', $', $actionParams) ?>) {
        $this->findModel($<?= implode(', $', $actionParams) ?>)->delete();
        return $this->redirect(['index']);
    }

    /**
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return <?= $modelClass . "\n" ?>
     * @throws NotFoundHttpException
     */
    protected function findModel($<?= implode(', $', $actionParams) ?>) {
        $<?= $modelVarName ?> = <?= $modelClass ?>::findOne(<?= $generator->generateFindOneCondition() ?>);
        if (!$<?= $modelVarName ?>) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $<?= $modelVarName ?>;
    }
}

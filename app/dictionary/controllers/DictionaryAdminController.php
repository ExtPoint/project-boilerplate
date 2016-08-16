<?php
namespace app\dictionary\controllers;

use Yii;
use app\dictionary\models\Dictionary;
use app\dictionary\forms\DictionarySearch;
use app\core\base\AppController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\profile\enums\UserRole;
use yii\web\Request;

class DictionaryAdminController extends AppController {

    public static function coreMenus($urlPrefix = 'admin/dictionary') {
        $type = \Yii::$app->request instanceof Request ? \Yii::$app->request->get('type') : null;
        $name = \Yii::$app->request instanceof Request ? \Yii::$app->request->get('name') : null;

        return [
            'label' => 'Справочники',
            'url' => ["/dictionary/dictionary-admin/index"],
            'items' => [
                [
                    'label' => 'Справочники',
                    'url' => ["/dictionary/dictionary-admin/index"],
                    'urlRule' => $urlPrefix,
                ],
                [
                    'label' => 'Добавление',
                    'url' => ["/dictionary/dictionary-admin/update"],
                    'urlRule' => "$urlPrefix/create",
                ],
                [
                    'label' => 'Редактирование',
                    'url' => ["/dictionary/dictionary-admin/update", 'type' => $type, 'name' => $name],
                    'urlRule' => "$urlPrefix/update/<type>/<name>",
                ],
                [
                    'label' => 'Просмотр',
                    'url' => ["/dictionary/dictionary-admin/view", 'type' => $type, 'name' => $name],
                    'urlRule' => "$urlPrefix/view/<type>/<name>",
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
        $dictionarySearchModel = new DictionarySearch();
        $dataProvider = $dictionarySearchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'dictionarySearchModel' => $dictionarySearchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param string $type
     * @param string $name
     * @return mixed
     */
    public function actionView($type, $name) {
        return $this->render('view', [
            'dictionary' => $this->findModel($type, $name),
        ]);
    }

    /**
     * @param string $type
     * @param string $name
     * @return mixed
     */
    public function actionUpdate($type = null, $name = null) {
        $dictionaryModel = $type && $name ? $this->findModel($type, $name) : new Dictionary();

        if ($dictionaryModel->load(Yii::$app->request->post()) && $dictionaryModel->save()) {
            return $this->redirect(['index']);
        }
        return $this->render('update', [
            'dictionaryModel' => $dictionaryModel,
        ]);
    }

    /**
     * @param string $type
     * @param string $name
     * @return mixed
     */
    public function actionDelete($type, $name) {
        $this->findModel($type, $name)->delete();
        return $this->redirect(['index']);
    }

    /**
     * @param string $type
     * @param string $name
     * @return Dictionary
     * @throws NotFoundHttpException
     */
    protected function findModel($type, $name) {
        $dictionaryModel = Dictionary::findOne(['type' => $type, 'name' => $name]);
        if (!$dictionaryModel) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $dictionaryModel;
    }
}

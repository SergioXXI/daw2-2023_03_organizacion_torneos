<?php

namespace app\controllers;

use app\models\Direccion;
use app\models\DireccionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\IntegrityException;
use yii\data\ArrayDataProvider;

use Yii;

/**
 * DireccionController implements the CRUD actions for Direccion model.
 */
class DireccionController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],

                //Regular acciones permitidas del controlador para los diversos usuarios
                'access' => [
                    'class' => \yii\filters\AccessControl::class,
                    'rules' => [
                        [
                            //Al no especificar acciones se aplican para todas las existentes
                            'allow' => true,
                            'roles' => ['admin', 'sysadmin'],
                        ],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Direccion models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new DireccionSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Direccion model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        $pistasProvider = new ArrayDataProvider([
            'allModels' => $model->pista,
            'sort' => [
                'attributes' => ['id', 'nombre'],
            ],
            'pagination' => [
                'pageSize' => Yii::$app->params['limiteGridView-View'],
            ],
        ]);

        return $this->render('view', [
            'model' => $model,
            'pistasProvider' => $pistasProvider,
        ]);
    }

    /**
     * Creates a new Direccion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Direccion();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Direccion model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Direccion model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        try{
            $this->findModel($id)->delete();
        } catch (IntegrityException $e) {
            throw new yii\web\HttpException(500,"No se puede eliminar este registro ya que está siendo utilizado por otra tabla.", 405);
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Direccion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Direccion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Direccion::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}

<?php

namespace app\controllers;
use app\models\Direccion;
use app\models\Pista;
use app\models\PistaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Transaction;
use yii\data\Pagination;

/**
 * PistaController implements the CRUD actions for Pista model.
 */
class PistaController extends Controller
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
            ]
        );
    }

    /**
     * Muestra todas las pistas al usuario para poder consultar datos y disponibilidad de las mismas
     *
     * @return string
     */
    public function actionIndex()
    {
    
        $searchModel = new PistaSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $dataProvider->pagination->pageSize = \Yii::$app->params['limitePistas'];

        /*echo '<pre>';
        print_r($dataProvider->getModels());*/

        /*$query = Pista::find();
        $countQuery = clone $query;
        $pages = new Pagination([
            'totalCount' => $countQuery->count(),
            'pageSize' => \Yii::$app->params['limitePistas'],
        ]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('pistas', [
            'models' => $models,
            'pages' => $pages,
        ]);*/

        return $this->render('pistas', [
            'models' => $dataProvider,
            'searchModel' => $searchModel,
        ]);

    }


    /**
     * Lists all Pista models.
     *
     * @return string
     */
    public function actionList()
    {
        $searchModel = new PistaSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Pista model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    public function actionVerPista($id)
    {
        $model = $this->findModel($id);
        $reservas = $model->reservas;

        return $this->render('verpista', [
            'model' => $model,
            'reservas' => $reservas,
        ]);
    }

    /**
     * Creates a new Pista model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Pista();
        $model_direccion = new Direccion();

        //Primero se intenta crear la dirección
        //Para asegurar la integridad se van a realizar los guardados en formato transaccion
        //ya que se están generando dos modelos, el direccion y el pista
        $transaction = \Yii::$app->db->beginTransaction();

        if ($this->request->isPost) {
            if($model_direccion->load($this->request->post()) && $model_direccion->save()) {
                //Si se genera correctamente la entrada direccion se recoge la id dejada por la base de datos
                //Esta id será la id a guardar en la tabla Pista columna direccion_id
                $model->direccion_id = \Yii::$app->db->getLastInsertID();
                if ($model->load($this->request->post()) && $model->save()) {
                    //Si se llega a este punto se confirma la transaccion
                    $transaction->commit();
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'model_direccion' => $model_direccion,
        ]);
    }

    /**
     * Updates an existing Pista model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model_direccion = null;
        if($model !== null)
            $model_direccion = Direccion::findOne(['id' => $model->direccion_id]);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save() && $model_direccion->load($this->request->post()) && $model_direccion->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'model_direccion' => $model_direccion,
        ]);
    }

    /**
     * Deletes an existing Pista model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Pista model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Pista the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Pista::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}

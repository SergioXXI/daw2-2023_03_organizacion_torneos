<?php

namespace app\controllers;
use app\models\Direccion;
use app\models\Pista;
use app\models\PistaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\IntegrityException;

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

        
        if ($this->request->isPost) {
            
            //Primero se intenta crear la dirección
            //Para asegurar la integridad se van a realizar los guardados en formato transaccion
            //ya que se están generando dos modelos, el direccion y el pista
            $transaction = \Yii::$app->db->beginTransaction();
            
            if($model_direccion->load($this->request->post())) {

                //En caso de existir una dirección con los mismos parametros no se creará y simplemente
                //se asociara la direccion_ïd de la pista a esta dirección ya existente
                $existe = Direccion::findOne($model_direccion->getAttributes($model_direccion->fields())); //Al usar fields con get attributes solo se usan los campos rellenados, dejando así excluido el id de la busqueda
                if($existe !== null) {
                    //Si ya existe la dirección se asigna el id de la misma al nuevo modelo creado
                    $model->direccion_id = $existe->id;
                } else {
                    //Si no existe la dirección se crear una nueva y se le asigna el id de la creación
                    if($model_direccion->save()) {
                        //Si se genera correctamente la entrada direccion se recoge la id dejada por la base de datos
                        //Esta id será la id a guardar en la tabla Pista columna direccion_id
                        $model->direccion_id = \Yii::$app->db->getLastInsertID();
                    }
                }

                if ($model->load($this->request->post()) && $model->save()) {
                    //Si se llega a este punto se confirma la transaccion
                    $transaction->commit();
                    return $this->redirect(['view', 'id' => $model->id]);
                }   
            }
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
        //No haría falta comprobar si existe el modelo con dicha id ya que esa función lanza una excepcion si no existe
        $model_direccion = Direccion::findOne(['id' => $model->direccion_id]);

        
        //Si la dirección ha sido editada se comprueba si la nueva ya existe para asignarle dicha id,
        //si no se crea una nueva dirección y se le asigna esta nueva id generada
        if ($this->request->isPost) {
            
            //Para asegurar la integridad se van a realizar los guardados en formato transaccion
            //ya que se están generando dos modelos, el direccion y el pista
            $transaction = \Yii::$app->db->beginTransaction();
            
            if($model_direccion->load($this->request->post())) {

                
                //En caso de existir una dirección con los mismos parametros no se creará y simplemente
                //se asociara la direccion_ïd de la pista a esta dirección ya existente
                unset($model_direccion->id);
                $existe = Direccion::findOne($model_direccion->getAttributes($model_direccion->fields())); //Al usar fields con get attributes solo se usan los campos rellenados, dejando así excluido el id de la busqueda
                if($existe !== null) {
                    //Si ya existe la dirección se asigna el id de la misma al nuevo modelo creado
                    $model->direccion_id = $existe->id;
                } else {
                    //Si no existe la dirección se crear una nueva y se le asigna el id de la creación
                    if($model_direccion->save()) {
                        //Si se genera correctamente la entrada direccion se recoge la id dejada por la base de datos
                        //Esta id será la id a guardar en la tabla Pista columna direccion_id
                        $model->direccion_id = \Yii::$app->db->getLastInsertID();
                    }
                }

                if ($model->load($this->request->post()) && $model->save()) {
                    //Si se llega a este punto se confirma la transaccion
                    $transaction->commit();
                    return $this->redirect(['view', 'id' => $model->id]);
                }   
            }
        } else {
            $model->loadDefaultValues();
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
        try{
            $this->findModel($id)->delete();
        } catch (IntegrityException $e) {
            throw new \yii\web\HttpException(500,"No se puede eliminar este registro ya que está siendo utilizado por otra tabla.", 405);
        }

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

        throw new NotFoundHttpException(\Yii::t('app', 'The requested page does not exist.'));
    }
}

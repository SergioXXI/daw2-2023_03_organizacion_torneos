<?php

namespace app\controllers;
use app\models\Direccion;
use app\models\Pista;
use app\models\PistaSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\IntegrityException;
use yii\data\ArrayDataProvider;
use Yii;

/**
 * PistaController implements the CRUD actions for Pista model.
 */
class PistaController extends Controller
{

    public $defaultAction = 'pistas';

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
                            'actions' => ['index', 'view', 'update', 'create', 'delete'],
                            'allow' => true,
                            'roles' => ['admin', 'sysadmin'],
                        ],
                        [
                            'actions' => ['pistas', 'ver-pista',],
                            'allow' => true,
                            'roles' => ['@', '?']
                        ],
                    ],
                ],
            ]
        );
    }

    /* 
     * Acción que permite a un usuario visualizar un listado con todas las pistas existentes en la base de datos,
     * esta acción incluye la capacidad de filtrar dichas pistas segun los parametros recibidos
    */
    public function actionPistas()
    {
        //Creación del nuevo modelo de busqueda y uso mediante los parametros llegados por Get
        $searchModel = new PistaSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        //Se establece la paginación al limite establecido en el fichero params.php de config
        $dataProvider->pagination->pageSize = Yii::$app->params['limitePistas'];

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
    public function actionIndex()
    {
        //Creación del nuevo modelo de busqueda y uso mediante los parametros llegados por Get
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
        $model = $this->findModel($id);

        //Crear un nuevo arrayprovider que permite visualizar en que reservas
        //esta siendo utilizado este modelo
        $pistasProvider = new ArrayDataProvider([
            'allModels' => $model->reservas,
            'sort' => [
                'attributes' => ['id', 'fecha'],
            ],
            'pagination' => [
                'pageSize' => Yii::$app->params['limiteGridView-View'],
            ],
        ]);

        return $this->render('view', [
            'model' => $model,
            'reservasProvider' => $pistasProvider,
        ]);
    }


    public function actionVerPista($id)
    {
        $model = $this->findModel($id);
        //Crear dos modelos distintos para poder gestionar tanto los eventos mostrados
        //en el calendario como los mostrados abajo
        //Si se usa el mismo DataProvider al tener que cambiar entre paginar y no paginar
        //no serviria, ya que tras el primer getModels se queda configurada una de las dos opciones
        $reservas = $model->reservas;
        $reservasProvider = new ActiveDataProvider([
            'query' => $model->getReservas(),
            'sort' => [
                'defaultOrder' => [
                    'fecha' => SORT_ASC,
                ],
            ],
            'pagination' => [
                'pageSize' => Yii::$app->params['limiteEventos'],
            ],
        ]);

        return $this->render('verpista', [
            'model' => $model,
            'reservasProvider' => $reservasProvider,
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
            $transaction = Yii::$app->db->beginTransaction();
            
            if($model_direccion->load($this->request->post())) {

                //Si el numero llega vacio, como el campo en la db puede ser null, al hacer la busqueda con findOne no
                //realiza bien la comparación del numero y no detecta la dirección como existente aun estándo ya en la db
                //Por lo tanto si llega vacio se elimina
                if(empty($model_direccion->numero)) unset($model_direccion->numero);
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
                        $model->direccion_id = Yii::$app->db->getLastInsertID();
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
            $transaction = Yii::$app->db->beginTransaction();
            
            if($model_direccion->load($this->request->post())) {

                //Si el numero llega vacio, como el campo en la db puede ser null, al hacer la busqueda con findOne no
                //realiza bien la comparación del numero y no detecta la dirección como existente aun estándo ya en la db
                //Por lo tanto si llega vacio se elimina
                if(empty($model_direccion->numero)) unset($model_direccion->numero);
                //En caso de existir una dirección con los mismos parametros no se creará y simplemente
                //se asociara la direccion_ïd de la pista a esta dirección ya existente
                unset($model_direccion->id); //Excluir el id de la busqueda
                $existe = Direccion::findOne($model_direccion->getAttributes($model_direccion->fields())); //Al usar fields con get attributes solo se usan los campos rellenados
                if($existe !== null) {
                    //Si ya existe la dirección se asigna el id de la misma al nuevo modelo creado
                    $model->direccion_id = $existe->id;
                } else {
                    //Técnicamente se está editando una dirección, pero si al editarla no existe se creará, por lo tanto, hay que activar NewRecord
                    $model_direccion->isNewRecord = true; 
                    //Si no existe la dirección se crear una nueva y se le asigna el id de la creación
                    if($model_direccion->save()) {
                        //Si se genera correctamente la entrada direccion se recoge la id dejada por la base de datos
                        //Esta id será la id a guardar en la tabla Pista columna direccion_id
                        $model->direccion_id = Yii::$app->db->getLastInsertID();
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
     * 
     * Explicación de los casos de borrado.
     *  1- Supuesto 1: si se borra una pista sin ninguna reserva asociada.
     *      1. Simplemente se realiza el borrado de la pista eliminando la entrada de la db
     *  2- Supuesto 2: si se borra una pista con al menos una reserva asociada.
     *      1. Si la entrada de la reserva unicamente está asociada con la pista se eliminan
     *         tanto la entrada de la pista como la entrada de la reserva de la db, eliminando
     *         primeramente la entrada que las une ubicada en la tabla reserva_pista.
     *          1. Si además la reserva esta asociada a un partido se establece el reserva_id de
     *             la tabla partido a null antes de la eliminación de la reserva.
     *      2. Si la entrada de la reserva, a parte de estar asociada con la pista, también lo
     *         está con materiales mediante una entrada en la tabla reserva_materiales
     *         no es eliminada de la db, simplemente es eliminada la relación con la pista de la
     *         tabla reserva_pista y la pista es eliminada.
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $reservas_pista = $model->reservaPista;
        //Antes de comenzar el borrado se inicia una transaccion para asegurarse
        //de que el borrado se realiza completamente o no se realiza nada en caso de error
        $transaction = Yii::$app->db->beginTransaction();
        if(empty($reservas_pista)) $model->delete(); //Supuesto 1
        else { //Supuesto 2
            foreach($reservas_pista as $reserva_pista) {
                $reserva = $reserva_pista->reserva;
                $reservas_material = $reserva->reservaMateriales;
                if(empty($reservas_material)) { //Supuesto 2.1
                    $reserva_pista->delete();
                    $partido = $reserva->partido;
                    if(!empty($partido)) { //Supuesto 2.1.1
                        $partido->reserva_id = null;
                        if($partido->save()) {
                            $reserva->delete();
                        }
                    } else {
                        $reserva->delete();
                    }
                } else { //Supuesto 2.2
                    $reserva_pista->delete();
                }
            }
            $model->delete();
        }

        $transaction->commit();
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

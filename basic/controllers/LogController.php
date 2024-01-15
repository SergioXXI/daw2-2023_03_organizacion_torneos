<?php

namespace app\controllers;

use app\models\Log;
use app\models\LogSearch;
use app\widgets\Alert;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Request;

use Yii;


/**********************************************************************************************/
/*                                          IMPORTANTE                                        
 * 
 * por defecto el registro de logs está desactivado ya que genera una gran cantidad de datos
 * muy rapidamente, si se quiere probar este controlador hay que descomentar las líneas del
 * fichero de configuracion config/web.php correspondientes al registro de logs
 * Estas líneas se encuentran dentro del atributo log y son las siguientes:
 * 
 * [
                    'class' => 'app\components\CustomDbTarget',
                    'levels' => ['info'],
                    'logTable' => 'log', // the name of the log table
                ],
                [
                    'class' => 'app\components\CustomDbTarget',
                    'levels' => ['error'],
                    'logTable' => 'log', // the name of the log table
                ],
                [
                    'class' => 'app\components\CustomDbTarget',
                    'levels' => ['warning'],
                    'logTable' => 'log', // the name of the log table
                ],
                [
                    'class' => 'app\components\CustomDbTarget',
                    'levels' => ['trace'],
                    'logTable' => 'log', // the name of the log table
                ],
**********************************************************************************************/

/**
 * LogController implements the CRUD actions for Log model.
 * 
 */
class LogController extends Controller
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
     * Lists all Log models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new LogSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);


        //Determinar si se quiere o no la paginación
        //Esta función es util por si se quieren seleccionar multiples
        //registros para realizar borrados
        if($this->request->get('pagination') == '0') {
            $paginar = false;
            $dataProvider->pagination = false;
        }
        else {
            $dataProvider->pagination->pageSize = Yii::$app->params['limiteLog'];
            $paginar = true;
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'paginar' => $paginar,
        ]);
    }

    /**
     * Displays a single Log model.
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


    /* 
     * Obtiene todos los registros de la tabla LOG de la base de datos y los guardar.
     * en un fichero temporal el cual es enviado al usuario para su descarga.
     * @return \yii\web\Response (File)
     */
    public function actionExportar()
    {
        $models = Log::find()->all();
        //Se genera el fichero temporal y se guarda en el directorio temporal por defecto del sistema
        $fichero = tempnam(sys_get_temp_dir(),'prefijo');
        
        //Se recorren todos los modelos y se escribe la cadena formateada en el fichero
        foreach($models as $model) {
            $linea = $model->log_time . ' (' . $model->id . ') ' . $model->prefix . '[' . $model->level . ']' .
            '[' . $model->category . '] ' . $model->message . "\n";
            file_put_contents($fichero,$linea,FILE_APPEND); //Flag file_append para realizar inserción al final del fichero
        }

        //La respuesta se encapsula en la siguiente secuencia para asegurarse de que tras devolver el fichero
        //este es desvinculado, haciendo que se elimine al ser temporal, de esta forma se tiene un borrado
        //controlado gracias al segmento finally que siempre se ejecuta independientemente de lo que suceda en el try
        try {
            Yii::$app->response->sendFile($fichero, 'logs.log')->send();
        } finally {
            unlink($fichero);
        }
    }

    /**
     * Creates a new Log model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    /* public function actionCreate()
    {
        $model = new Log();

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
    } */

    /**
     * Updates an existing Log model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    /* public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    } */


    //Función que determina la acción que se ha pulsado en el formulario de la vista index
    public function actionBotonGestor()
    {
        $accion = Yii::$app->request->post('accion');

        //Ejecutar una acción en función del boton recibido por post
        switch ($accion) {
            case 'BtnEliminarSeleccionados':
                $this->eliminarSeleccionados();
                break;
            case 'BtnEliminarFiltrados':
                $this->eliminarFiltrados();
                break;
            case 'BtnEliminarTodos':
                $this->eliminarTodos();
                break;
            default:
                return $this->redirect(['index']);
        }

        return $this->redirect(['index']);
    }

    /**
     * Deletes an existing Log model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     * 
     * Este delete simplemente elimina el log que haya sido seleccionado
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }


    /*
     * Función que se encarga de eliminar los registros que hayan sido seleccionados mediante el checkbox de la vista index.php
     * Este borrado recogerá el id de los logs que han sido pasados por post y los irá borrando uno a uno
     */ 
    public function eliminarSeleccionados()
    {
        //Como se van a borrar varias entradas una por una se va a realizar en formato transacción
        //de esta forma se asegura que solo se actualiza la db si todas las entradas se han borrado correctamente
        $transaction = Yii::$app->db->beginTransaction();
        
        if ($this->request->isPost) {
            if (empty($this->request->post('selection'))) Yii::$app->session->setFlash('error', 'No se ha seleccionado ningun elemento para el borrado.');
            else
                foreach($this->request->post('selection') as $id)
                    $this->findModel($id)->delete();
        }

        $transaction->commit();

        return $this->redirect(['index']);
    }

    /*
     * Función que se encarga de eliminar los registros que cumplan con los filtros seleccionados en la vista index.php
     * Este borrado hará una petición para obtener los logs que cumplan los filtros recibidos y los borrara uno por uno
     */ 
    public function eliminarFiltrados()
    {
        //Como se van a borrar varias entradas una por una se va a realizar en formato transacción
        //de esta forma se asegura que solo se actualiza la db si todas las entradas se han borrado correctamente
        $transaction = Yii::$app->db->beginTransaction();

        $searchModel = new LogSearch();
        $dataProvider = $searchModel->search($this->request->post()); //Los filtros llegan por post
        $dataProvider->pagination = false; //Eliminar la paginación para hacer el borrado

        //Obtener el modelo del dataprovider para poder eliminarlo
        foreach($dataProvider->getModels() as $model)
            $model->delete();

        $transaction->commit();

        return $this->redirect(['index']);
    }

    /*
     * Función que se encarga de eliminar todos los registro
     */ 
    public function eliminarTodos()
    {
        Log::deleteAll();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Log model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Log the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Log::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    /* Codigo fuente de como funciona la clase Pagination adaptado a el caso particular de activar y desactivar paginación */
    public static function desactivarPag($activar = true)
    {
        $request = Yii::$app->getRequest();
        $params = $request instanceof Request ? $request->getQueryParams() : [];

        $params['pagination'] = $activar;

        $params[0] = Yii::$app->controller->getRoute();
        $urlManager = Yii::$app->getUrlManager();

        return $urlManager->createUrl($params);
    }

    /**
     * Returns the value of the specified query parameter.
     * This method returns the named parameter value from [[params]]. Null is returned if the value does not exist.
     * @param string $name the parameter name
     * @param string|null $defaultValue the value to be returned when the specified parameter does not exist in [[params]].
     * @return string|null the parameter value
     */
    protected function getQueryParam($name, $defaultValue = null)
    {
        $request = Yii::$app->getRequest();
        $params = $request instanceof Request ? $request->getQueryParams() : [];
        

        return isset($params[$name]) && is_scalar($params[$name]) ? $params[$name] : $defaultValue;
    }

}

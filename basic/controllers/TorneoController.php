<?php

namespace app\controllers;

use app\models\EquipoParticipante;
use app\models\Participante;
use app\models\TorneoImagen;
use app\models\Imagen;
use app\models\Torneo;
use app\models\Premio;
use app\models\TorneoSearch;
use app\models\User;
use Exception;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;

use Yii;

/**
 * TorneoController implements the CRUD actions for Torneo model.
 */
class TorneoController extends Controller
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
                'access' => [
                    'class' => \yii\filters\AccessControl::class,
                    'rules' => [
                        [
                            'actions' => ['index', 'view','ver-partidos'],
                            'allow' => true,
                            //'roles' => ['sysadmin','admin', 'usuario', 'organizador', 'gestor'],
                            
                        ],
                        [
                            'actions' => ['create', 'update', 'delete'],
                            'allow' => true,
                            'roles' => ['sysadmin','admin','organizador'],
                        ],
                    ],
                ],
            ]
        );
    }
    
    /**
     * Lists all Torneo models.
     * No admin view
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TorneoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        /* $query = Torneo::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10, // Numero de paginas
            ],
        ]); */

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Torneo model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        $equipoProvider = new ArrayDataProvider([
            'allModels' => $model->equipos,
            'sort' => [
                'attributes' => ['id', 'nombre'],
            ],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $premioProvider = new ArrayDataProvider([
            'allModels' => $model->premios,
            'sort' => [
                'attributes' => ['id', 'nombre'],
            ],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('view', [
            'model' => $model,
            'equipoProvider' => $equipoProvider,
            'premioProvider' => $premioProvider,
        ]);
    }

    /**
     * Creates a new Torneo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new torneo();
        $imagen = new Imagen();
        $union = new TorneoImagen();
        $equipoProvider = new ArrayDataProvider([
            'allModels' => $model->equipos,
            'sort' => [
                'attributes' => ['id', 'nombre'],
            ],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        $premioProvider = new ArrayDataProvider([
            'allModels' => $model->premios,
            'sort' => [
                'attributes' => ['id', 'nombre'],
            ],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        if ($model->load($this->request->post()) && $model->save())  {

            //if($this->request->post()['Torneo']['imageFile'])
            try{
                $destino = './imagenes';
                $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
                $rutaFichero = $destino . '/' . $model->imageFile;
                if ($model->subirImagen($destino)) {
                    
                    // file is uploaded successfully
                    $imagen->ruta = $rutaFichero;
                    $imagen->save();

                    $union->torneo_id = $model->id;
                    $union->imagen_id = $imagen->id;
                    $union->save();
                }
            }catch(Exception $e){
                return $this->render('view', [
                    'model' => $model,
                    'equipoProvider' => $equipoProvider,
                    'premioProvider' => $premioProvider,
                ]);
            }
                
                return $this->render('view', [
                    'model' => $model,
                    'equipoProvider' => $equipoProvider,
                    'premioProvider' => $premioProvider,
                ]);
            
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Torneo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $imagen = new Imagen();
        $union = new TorneoImagen();
        $equipoProvider = new ArrayDataProvider([
            'allModels' => $model->equipos,
            'sort' => [
                'attributes' => ['id', 'nombre'],
            ],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $premioProvider = new ArrayDataProvider([
            'allModels' => $model->premios,
            'sort' => [
                'attributes' => ['id', 'nombre'],
            ],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        if ($model->load($this->request->post()) && $model->save())  {
            //if($this->request->post()['Torneo']['imageFile'])
            try{
                $destino = './imagenes';
                $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
                $rutaFichero = $destino . '/' . $model->imageFile;
                if ($model->subirImagen($destino)) {
                    // file is uploaded successfully
                    $imagen->ruta = $rutaFichero;
                    $imagen->save();

                    $union->torneo_id = $model->id;
                    $union->imagen_id = $imagen->id;
                    $union->save();
                }
            }catch(Exception $e){
                return $this->render('view', [
                    'model' => $model,
                    'equipoProvider' => $equipoProvider,
                    'premioProvider' => $premioProvider,
                ]);
            }
            return $this->render('view', [
                'model' => $model,
                'equipoProvider' => $equipoProvider,
                'premioProvider' => $premioProvider,
            ]);
            
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Torneo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $t_e = $model->getTorneoEquipos();
        $t_i = $model->getTorneoImagens();
        $t_n = $model->getTorneoNormativas();
        $t_c = $model->getTorneoCategorias();
        $t_p = $model->getPartidos();
        $t_pre = $model->getPremios();
        if ($t_e !== null) {
            foreach ($t_e->all() as $entrada) {
                $entrada->delete();
            }
        }
        if ($t_i !== null) {
            foreach ($t_i->all() as $entrada) {
                $entrada->delete();
            }
        }
        if ($t_n !== null) {
            foreach ($t_n->all() as $entrada) {
                $entrada->delete();
            }
        }
        if ($t_c !== null) {
            foreach ($t_c->all() as $entrada) {
                $entrada->delete();
            }
        }
        if ($t_p !== null) {
            foreach ($t_p->all() as $entrada) {
                $p_e=$entrada->getPartidoEquipos();
                if ($p_e !== null) {
                    foreach ($p_e->all() as $entry) {
                        $entry->delete();
                    }
                }
                $entrada->delete();
            }
        }
        if ($t_pre !== null) {
            foreach ($t_pre->all() as $entrada) {
                $entrada->delete();
            }
        }
        $model->delete();

        return $this->redirect(['index']);
    }

    /*
     * Función que permite visualizar todos los partidos asociados a un
     * torneo y ver los equipos que se enfrentan en dichos partidos
    */
    public function actionVerPartidos($id)
    {
        $model = $this->findModel($id);
        $partidos = new ArrayDataProvider([
            'allModels' => $model->partidos,
            'sort' => [
                'attributes' => ['fecha'], //Se va a ordenar por fecha por defecto
                'defaultOrder' => ['fecha' => SORT_ASC],
            ],
            'pagination' => [
                'pageSize' => Yii::$app->params['limitePartidos'],
            ],
        ]);

        return $this->render('ver_partidos', [
            'torneo' => $model,
            'partidos' => $partidos,
        ]);
    }

    /**
     * Finds the Torneo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Torneo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Torneo::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
    
}

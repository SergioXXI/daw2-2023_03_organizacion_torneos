<?php

namespace app\controllers;

use app\models\Participante;
use app\models\ParticipanteSearch;
use app\models\TipoParticipante;
use app\models\Equipo;
use app\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

use Yii;

/**
 * ParticipanteController.
 * 
 * Acciones con las que se cuenta: 
 * actionIndex,actionView,actionAddEquipo,actionAbandonarEquipo,actionCreate,actionUpdate,actionDelete
 */
class ParticipanteController extends Controller
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
                    'rules' => [ //permisos para los distintos roles
                        [
                            'actions' => ['index'], //al index solo podrán acceder el gestor de equipos y los administradores
                            'allow' => true,
                            'roles' => ['sysadmin','admin', 'gestor'],
                        ],
                        [
                            'actions' => ['view','update','add-equipo', 'abandonar-equipo','delete','create'],
                            'allow' => true,
                            'roles' => ['sysadmin','admin', 'gestor', 'usuario'],
                        ],
                    ],
                ],
            ]
        );
    }
    

    /**
     * Lista todos los modelos de Participantes.
     *
     * @return string
     */
    public function actionIndex()
    {
        //se obtiene la informacion de los participantes
        $searchModel = new ParticipanteSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        //se carga la vista de index y se le pasa la informacion
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Crea la vista de un solo participante.
     * 
     * @param int $id ID del participante que se ve
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        //se busca el modelo del participante a partir del id recibido
        $model = $this->findModel($id);
        $participante = $this->findModel($id);

        //se guarda más información sobre el participante y el id del que está en sesión
        $participanteSesion = Participante::findOne(['usuario_id' => \Yii::$app->user->id]);
        $query = $model->getEquipos()->with('torneos');
        $equiposDataProvider = new \yii\data\ActiveDataProvider(['query' => $query]);
        $tieneEquipo = $query->count() > 0; //se guarda en una variable si está en algún equipo

        //se carga la vista con todo lo necesario
        return $this->render('view', [
            'model' => $model,
            'participante' => $participante,//modelo
            'participanteSesion' => $participanteSesion,//modelo
            'equiposDataProvider' => $equiposDataProvider,
            'tieneEquipo' => $tieneEquipo,
        ]);
    }


    /**
     * Función para añadir a un participante a un equipo
     * 
     * @param int $id ID del participante que se une a un equipo
     */
    public function actionAddEquipo($id)
    {
        //se busca el modelo del participante a partir del id recibido y se crea un nuevo modelo de equipo
        $participante = $this->findModel($id);
        $equipoModel = new Equipo();

        //se obtienen los ID de los equipos a los que ya pertenece el participante
        $equiposDelParticipante = ArrayHelper::map($participante->equipos, 'id', 'id');

        //se filtran los equipos en los que no está y obtiene nombre y licencia
        $equiposDisponibles = Equipo::find()
            ->where(['NOT IN', 'id', $equiposDelParticipante])
            ->all();

            $listaEquipos = ArrayHelper::map($equiposDisponibles, 'id', function ($equipo) {
                return $equipo->nombre . ' (' . $equipo->licencia . ')';
            });

        //se recoge el id del equipo en el que se quiere entrar, si no se está ya se une
        if (\Yii::$app->request->isPost) {
            $equipoId = \Yii::$app->request->post('Equipo')['id'];
            if ($equipoId && !in_array($equipoId, $equiposDelParticipante)) {
                //lógica para añadir el participante al equipo
                \Yii::$app->db->createCommand()->insert('equipo_participante', [
                    'equipo_id' => $equipoId,
                    'participante_id' => $id,
                ])->execute();

                return $this->redirect(['view', 'id' => $id]);
            }
        }

        //se carga la vista con todo lo necesario
        return $this->render('add-equipo', [
            'participante' => $participante,
            'equipoModel' => $equipoModel,
            'listaEquipos' => $listaEquipos,
        ]);
    }

    /**
     * Función para que un participante abandone un equipo
     * 
     * @param int $equipoId ID del que se abandona
     * @param int $participanteId ID del participante que abandona un equipo
     */
    public function actionAbandonarEquipo($equipoId, $participanteId)
    {
        //se busca el modelo del equipo a partir del id recibido
        $equipo  = (Equipo::findOne($equipoId));
        
        //si es el creador el que abandona el equipo hay que establecer un nuevo creador
        if($equipo->creador_id  == $participanteId)
        {
            //se buscan otros participantes en el equipo
            $otrosParticipantes = \Yii::$app->db->createCommand('SELECT participante_id FROM equipo_participante WHERE equipo_id = :equipoId AND participante_id != :participanteId')
                ->bindValue(':equipoId', $equipoId)
                ->bindValue(':participanteId', $participanteId)
                ->queryAll();
            if (!empty($otrosParticipantes)) {
                //si hay otros participantes, selecciona uno como nuevo creador
                $nuevoCreadorId = $otrosParticipantes[0]['participante_id'];
                $equipo->creador_id = $nuevoCreadorId;
            }else {
                //si no hay otros participantes, establece creador_id a null
                $equipo->creador_id = null;
            } 
            //se guarda el cambio en el equipo
             $equipo->save();   
        }
        //lógica para eliminar la relación entre el equipo y el participante
        \Yii::$app->db->createCommand()->delete('equipo_participante', [
            'equipo_id' => $equipoId,
            'participante_id' => $participanteId,
        ])->execute();

        //se redirecciona al usuario a la vista del participante
        return $this->redirect(['view', 'id' => $participanteId]);
    }


    /**
     * Crea un nuevo modelo de Participante.
     * 
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        //se crea un nuevo modelo de participante y de usuario
        $model = new Participante();
        $usuarioModel = new User();
        $userType = \Yii::$app->request->post('userType', null);

        //se guarda el id del usuario en sesión
        $idUser = \Yii::$app->request->get('id', null);

        //obtiene todos los tipos de participantes que hay en la base de datos
        $tiposParticipantes = TipoParticipante::find()->all();
        $listaTiposParticipantes = ArrayHelper::map($tiposParticipantes, 'id', 'nombre');

        //se convierte el array para el desplegable
        $listaTiposParticipantes = ArrayHelper::map($tiposParticipantes, 'id', 'nombre');    

        //se obtienen los usuarios que no están vinculados a un participante
        $usuarios = User::find()->leftJoin('participante', 'usuario.id = participante.usuario_id')
            ->where(['participante.usuario_id' => null])
            ->all();
        $listaUsuarios = ArrayHelper::map($usuarios, 'id', 'nombre'); //se guardan los nombres de los usuarios que hay

        if ($this->request->isPost) {
            //se cargan los datos en el modelo Participante
            $model->load($this->request->post());
            
            //verifica si se seleccionó un usuario existente
            if (!empty($this->request->post('Participante')['usuario_id'])) {
                //participante vinculado a un usuario existente
                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } else {
                $usuarioModel->load($this->request->post());
                //se crea un nuevo usuario y un nuevo participante
                if ($usuarioModel->save()) {
                    $model->usuario_id = $usuarioModel->id;
                    if ($model->save()) {
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                }
            }
        }

        //se carga la vista de creación junto a todo lo necesario
        return $this->render('create', [
            'model' => $model,
            'listaTiposParticipantes' => $listaTiposParticipantes,
            'listaUsuarios' => $listaUsuarios,
            'idUser' => $idUser,
            'usuarioModel' => $usuarioModel,
            'userType' => $userType,
        ]);
    }

    /**
     * Edita un participante existente.
     * 
     * @param int $id ID del participante que se edita
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        //se busca el modelo del participante a partir del id recibido, y del usuario en el que se guarda el nombre
        $model = $this->findModel($id);
        $usuarioModel = User::findOne($model->usuario_id);

        //se obtienen todos los tipos de participantes en la base de datos
        $tiposParticipantes = TipoParticipante::find()->all();
        $listaTiposParticipantes = ArrayHelper::map($tiposParticipantes, 'id', 'nombre');

        //se convierte el array para el desplegable
        $listaTiposParticipantes = ArrayHelper::map($tiposParticipantes, 'id', 'nombre');    

        //se recogen los cambios y se guardan en la base de datos
        if ($this->request->isPost && $model->load($this->request->post()) && $model->save() && $usuarioModel->load($this->request->post()) && $usuarioModel->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        //se carga la vista de edita con todo lo necesario
        return $this->render('update', [
            'model' => $model,
            'listaTiposParticipantes' => $listaTiposParticipantes,
            'usuarioModel' => $usuarioModel,
        ]);
    }

    /**
     * Elimina un Participante existente.
     * 
     * @param int $id ID del participante que se elimina
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        //se inicia una transacción para asegurar que el participante existe
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $participante = Participante::findOne($id);
            if (!$participante) {
                throw new NotFoundHttpException("Participante no encontrado.");
            }
    
            //se comprueba los equipos en los que esta y si se puede eliminar en función del estado de torneos
            $puedeBorrar = true;
            $fechaActual = new \DateTime();
            $fechaActualString = $fechaActual->format('Y-m-d H:i:s');
            foreach ($participante->equipos as $equipo) {
                foreach ($equipo->torneos as $torneo) {
                    if ($torneo->fecha_fin === null || $torneo->fecha_fin > $fechaActualString) {
                        //si el torneo no ha terminado o la fecha fin es null no se puede borrar
                        $puedeBorrar = false;
                        break 2; //sale de ambos bucles
                    }
                }
            }
            
            //si puede borrar
            if ($puedeBorrar) {
                foreach ($participante->equiposCreador as $equipo) {
                    //se accede a todos los equipos en los que esta
                    //se guardan los demás participantes de los equipos en los que este
                    $otrosParticipantes = \Yii::$app->db->createCommand('SELECT participante_id FROM equipo_participante WHERE equipo_id = :equipoId AND participante_id != :participanteId')
                    ->bindValue(':equipoId', $equipo->id)
                    ->bindValue(':participanteId', $participante->id)
                    ->queryAll();
                    if (!empty($otrosParticipantes)) {
                        //si hay otros participantes, se selecciona uno como nuevo creador
                        $nuevoCreadorId = $otrosParticipantes[0]['participante_id'];
                        $equipo->creador_id = $nuevoCreadorId;
                    }else {
                        //si no hay otros participantes, establece creador_id a null
                        $equipo->creador_id = null;
                    }
                    //se guarda el cambio en el equipo
                    $equipo->save();     
                }
                
                //se elimina el participante de los equipos que estan en algun torneo que ya ha finalizado
                \Yii::$app->db->createCommand()->delete('equipo_participante', ['participante_id' => $id])->execute();
                //se elimina el documento del participante
                \Yii::$app->db->createCommand()->delete('participante_documento', ['participante_id' => $id])->execute();
                
                //se borra el participante y se redirige a un lugar u otro en función del rol
                $participante->delete();
                $transaction->commit();
                \Yii::$app->session->setFlash('success', 'Participante borrado con éxito.');
                if(\Yii::$app->user->can('admin') || \Yii::$app->user->can('sysadmin') || \Yii::$app->user->can('gestor')){
                    return $this->redirect(['index']);
                }else{
                    return $this->redirect(['user/view-profile', 'id' => $participante->usuario->id]);
                }
            } else {
                //si no se puede borrar el participante
                \Yii::$app->session->setFlash('error', 'El participante pertenece a un equipo que está en un torneo activo .');
                return $this->redirect(['view', 'id' => $id]);
            }
        } catch (\Exception $e) { //se gestionan posibles excepciones
            $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    /**
     * Finds the Participante model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Participante the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        //busca el modelo de participante que se le pida con el id
        if (($model = Participante::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}

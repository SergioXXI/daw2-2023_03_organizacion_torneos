<?php

namespace app\controllers;


use app\models\Equipo;
use app\models\Usuario;
use app\models\Participante;
use app\models\Categoria;
use app\models\Torneo;
use app\models\EquipoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use app\controllers\ArrayDataProvider;



/**
 * EquipoController.
 * 
 * actionIndex, actionView, actionCreate, actionUpdate, actionAddParticipante, actionExpulsarParticipante, actionAddTorneo, actionSalirTorneo, actionDelete, actionLider
 */
class EquipoController extends Controller
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
                            'actions' => ['index'],
                            'allow' => true,
                            'roles' => ['sysadmin','admin', 'gestor'],
                        ],
                        [
                            'actions' => ['update','create','view','add-participante','expulsar-participante','add-torneo','salir-torneo','lider','delete'],
                            'allow' => true,
                            'roles' => ['sysadmin','admin', 'gestor', 'usuario'],
                        ],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Equipo models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new EquipoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionLider( $equipoId,$participante_id)
    {
        $equipo= $this->findModel($equipoId);
        \Yii::$app->db->createCommand()->update('equipo', [
             // Replace with the actual attributes and values you want to update
            'creador_id' => $participante_id,
            // ...
        ], [
            'id' => $equipoId,
        ])->execute();
        return $this->redirect(['view', 'id' => $equipoId]);
    }

    /**
     * Displays a single Equipo model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {

        $model = $this->findModel($id);
        $equipo = $this->findModel($id);
        $participanteSesion = Participante::findOne(['usuario_id' => \Yii::$app->user->id]);

        $clonesIds = Equipo::find()
        ->select('id')
        ->where(['nombre' => $model->nombre, 'descripcion' => $model->descripcion,'licencia' => $model->licencia,'categoria_id' => $model->categoria_id]) // Ajusta los criterios según sea necesario
        ->column();

        $fechaActual = new \DateTime();
        $fechaActualString = $fechaActual->format('Y-m-d H:i:s'); // Convierte a formato 'YYYY-MM-DD HH:MM:SS'

        // Encuentra los torneos finalizados
        $torneosFinalizados = (new \yii\db\Query())
            ->select('torneo.*')
            ->from('torneo')
            ->leftJoin('torneo_equipo', 'torneo.id = torneo_equipo.torneo_id')
            ->where(['<', 'fecha_fin', $fechaActualString])
            ->andWhere(['IN', 'torneo_equipo.equipo_id', $clonesIds])
            ->all();

        $tieneTorneosFin = count($torneosFinalizados) > 0;

        // Encuentra los torneos en curso
        $torneosEnCurso = (new \yii\db\Query())
            ->select('torneo.*')
            ->from('torneo')
            ->leftJoin('torneo_equipo', 'torneo.id = torneo_equipo.torneo_id')
            ->where(['AND',
                ['<', 'fecha_limite', $fechaActualString], // La fecha límite ya pasó
                ['OR', 
                    ['>', 'fecha_fin', $fechaActualString], // La fecha fin no ha llegado
                    ['fecha_fin' => null] // O la fecha fin es nula
                ]
            ])
            ->andWhere(['IN', 'torneo_equipo.equipo_id', $clonesIds])
            ->all();
            
        $tieneTorneosCurso = count($torneosEnCurso) > 0;

        $torneosEnInscripcion = (new \yii\db\Query())
            ->select('torneo.*')
            ->from('torneo')
            ->leftJoin('torneo_equipo', 'torneo.id = torneo_equipo.torneo_id')
            ->where(['>', 'fecha_limite', $fechaActualString])
            ->andWhere(['IN', 'torneo_equipo.equipo_id', $clonesIds])
            ->all();

        $tieneEnInscripcion = count($torneosEnInscripcion) > 0;

        // Obtener participantes del equipo
        $query = Participante::find()
            ->joinWith(['usuario', 'tipoParticipante'])
            ->innerJoin('equipo_participante', 'equipo_participante.participante_id = participante.id')
            ->where(['equipo_participante.equipo_id' => $id]);
        
        $dataProvider = new \yii\data\ActiveDataProvider(['query' => $query]);
       
        $tieneParticipantes = $query->count() > 0;

        $usuario=$model->getUsuario()->one();


        return $this->render('view', [
            'model' => $model,
            'usuario' => $usuario,
            'equipo' => $equipo,
            'participanteSesion' => $participanteSesion,
            'dataProvider' => $dataProvider,
            'tieneParticipantes' => $tieneParticipantes,
            'torneosFinalizados' => $torneosFinalizados,
            'torneosEnCurso' => $torneosEnCurso,
            'torneosEnInscripcion' => $torneosEnInscripcion,
            'tieneTorneosFin' => $tieneTorneosFin,
            'tieneTorneosCurso' => $tieneTorneosCurso,
            'tieneEnInscripcion' => $tieneEnInscripcion,
        ]);
    }

    /**
     * Creates a new Equipo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Equipo();
        
        // Obtener todas las categorías
        $categorias = Categoria::find()
            ->orderBy('nombre')
            ->all();

        $participantes = Participante::find()
            ->joinWith('usuario')
            ->orderBy('nombre')
            ->all();

        // Convertir a un array para el desplegable, usando 'id' como clave y 'nombre' como valor
        $listaCategorias = ArrayHelper::map($categorias, 'id', 'nombre');

        $listaParticipantes = ArrayHelper::map($participantes, 'id', 'usuario.nombre');
        
        $participanteSesion = Participante::findOne(['usuario_id' => \Yii::$app->user->id]);
        

  
        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                if($model->creador_id != null){
                    \Yii::$app->db->createCommand()->insert('equipo_participante', [
                        'equipo_id' => $model->id,
                        'participante_id' => $model->creador_id,
                    ])->execute();
                }
            return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'participanteSesion' => $participanteSesion,
            'listaCategorias' => $listaCategorias, //Pasar la lista de categorías a la vista
            'listaParticipantes' => $listaParticipantes, 
            'participantes' => $participantes,
        ]);

    }

    /**
     * Updates an existing Equipo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $equipo = $this->findModel($id);
        $participanteSesion = Participante::findOne(['usuario_id' => \Yii::$app->user->id]);

        $participantes = Participante::find()
                ->joinWith('usuario')
                ->orderBy('nombre')
                ->all();

        $listaParticipantes = ArrayHelper::map($participantes, 'id', 'usuario.nombre');
        /////////////////////////////
        //logica de clonación
        //////////////////////////
        if ((!\Yii::$app->user->can('gestor'))&&(!\Yii::$app->user->can('organizador'))&&(!\Yii::$app->user->can('sysadmin'))&&(\Yii::$app->user->can('usuario'))) 
        { 
            $inscritoEnTorneos = (new \yii\db\Query())
                ->from('torneo_equipo')
                ->where(['equipo_id' => $id])
                ->exists();
            
            if ($inscritoEnTorneos) {
                // Lógica para clonar el equipo
                $nuevoEquipo = new Equipo();
                $nuevoEquipo->attributes = $model->attributes; // Copia los atributos
                //$nuevoEquipo->nombre .= " (Clon)"; // Opcional: Modifica el nombre para indicar que es un clon
                $nuevoEquipo->save(false); // Guarda el nuevo equipo, asumiendo que la validación no es necesaria


                // Obtener los ID de los participantes actuales del equipo
                $participantesActuales = (new \yii\db\Query())
                    ->select('participante_id')
                    ->from('equipo_participante')
                    ->where(['equipo_id' => $id])
                    ->column();

                // Clonar las relaciones con los participantes
                foreach ($participantesActuales as $participanteId) {
                    \Yii::$app->db->createCommand()
                        ->insert('equipo_participante', [
                            'equipo_id' => $nuevoEquipo->id,
                            'participante_id' => $participanteId
                        ])->execute();
                }

                // Redirige a la acción de actualizar para el nuevo equipo clonado
                return $this->redirect(['update', 'id' => $nuevoEquipo->id]);
            }
        }
       //*/////////////////////////////////////

        // Obtener todas las categorías
        $categorias = Categoria::find()
            ->orderBy('nombre')
            ->all();

        // Convertir a un array para el desplegable, usando 'id' como clave y 'nombre' como valor
        $listaCategorias = ArrayHelper::map($categorias, 'id', 'nombre');

        // Obtener participantes del equipo
        
        $query = Participante::find()
            ->joinWith(['usuario', 'tipoParticipante'])
            ->innerJoin('equipo_participante', 'equipo_participante.participante_id = participante.id')
            ->where(['equipo_participante.equipo_id' => $id]);
        

        $dataProvider = new \yii\data\ActiveDataProvider(['query' => $query]);
        $tieneParticipantes = $query->count() > 0;

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            if($model->creador_id != null){
                \Yii::$app->db->createCommand()->insert('equipo_participante', [
                    'equipo_id' => $model->id,
                    'participante_id' => $model->creador_id,
                ])->execute();
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $usuario=$model->getUsuario()->one();

        return $this->render('update', [
            'model' => $model,
            'usuario' => $usuario,
            'equipo' => $equipo,
            'participanteSesion' => $participanteSesion,
            'listaParticipantes' => $listaParticipantes, 
            'listaCategorias' => $listaCategorias,
            'dataProvider' => $dataProvider,
            'tieneParticipantes' => $tieneParticipantes,
        ]);
    }

    public function actionAddParticipante($id)
    {
        $equipo = $this->findModel($id);
        $participanteModel = new Participante();

        // Obtén los ID de los participantes ya en el equipo
        $participantesEnEquipo = ArrayHelper::map($equipo->participantes, 'id', 'id');

        // Filtra los participantes que no están en el equipo y obtén sus nombres y emails
        $participantesDisponibles = Participante::find()
            ->joinWith('usuario') // Asegúrate de que exista la relación 'usuario' en tu modelo Participante
            ->where(['NOT IN', 'participante.id', $participantesEnEquipo])
            ->all();
            $listaParticipantes = ArrayHelper::map($participantesDisponibles, 'id', function ($participante) {
                return $participante->usuario->nombre . ' (' . $participante->usuario->email . ')';
            });

        if (\Yii::$app->request->isPost) {
            $participanteId = \Yii::$app->request->post('Participante')['id'];
            if ($participanteId && !in_array($participanteId, $participantesEnEquipo)) {
                // Lógica para añadir el participante al equipo
                \Yii::$app->db->createCommand()->insert('equipo_participante', [
                    'equipo_id' => $id,
                    'participante_id' => $participanteId,
                ])->execute();

                return $this->redirect(['view', 'id' => $id]);
            }
        }

        return $this->render('add-participante', [
            'equipo' => $equipo,
            'participanteModel' => $participanteModel,
            'listaParticipantes' => $listaParticipantes,
        ]);
    }

    public function actionExpulsarParticipante($equipoId, $participanteId)
    {
        $equipo  = (Equipo::findOne($equipoId));
        
        if($equipo->creador_id  == $participanteId)
        {
            // Contar otros participantes en el equipo
            $otrosParticipantes = \Yii::$app->db->createCommand('SELECT participante_id FROM equipo_participante WHERE equipo_id = :equipoId AND participante_id != :participanteId')
                ->bindValue(':equipoId', $equipoId)
                ->bindValue(':participanteId', $participanteId)
                ->queryAll();
            if (!empty($otrosParticipantes)) {
                // Hay otros participantes, selecciona uno como nuevo creador
                $nuevoCreadorId = $otrosParticipantes[0]['participante_id'];
                $equipo->creador_id = $nuevoCreadorId;
            }else {
                // No hay otros participantes, establece creador_id a null
                $equipo->creador_id = null;
            } 
            // Guardar el cambio en el equipo
             $equipo->save();   
        }
        
        \Yii::$app->db->createCommand()->delete('equipo_participante', [
            'equipo_id' => $equipoId,
            'participante_id' => $participanteId,
        ])->execute();
        return $this->redirect(['update', 'id' => $equipoId]);
    }

    public function actionAddTorneo($id)
    {
        $model = $this->findModel($id);
        $equipo = $this->findModel($id);
        $torneoModel = new Torneo();
        // Encuentra todos los clones del equipo
        $clonesIds = Equipo::find()
            ->where(['nombre' => $model->nombre, 'descripcion' => $model->descripcion,'licencia' => $model->licencia,'categoria_id' => $model->categoria_id]) // Asegúrate de ajustar los criterios para identificar clones
            ->select('id')
            ->column();
    

        $fechaActual = new \DateTime();
        $fechaActualString = $fechaActual->format('Y-m-d H:i:s');
        // Encuentra los torneos disponibles falat mirar si el torneo esta lleno
        $torneosDisponibles = (new \yii\db\Query())
            ->select([
                'torneo.*',
                'equipos_en_torneo' => '(SELECT COUNT(*) FROM torneo_equipo WHERE torneo_equipo.torneo_id = torneo.id)'
            ])
            ->from('torneo')
            ->where(['>', 'torneo.fecha_limite', $fechaActualString])
            ->andWhere(['NOT IN', 'torneo.id', 
                (new \yii\db\Query())
                    ->select('torneo_id')
                    ->from('torneo_equipo')
                    ->where(['IN', 'equipo_id', $clonesIds])
            ])
            ->having(['<', 'equipos_en_torneo', new \yii\db\Expression('torneo.participantes_max')])
            ->groupBy('torneo.id')
            ->all();
        
        $listaTorneos = new \yii\data\ArrayDataProvider([
            'allModels' => $torneosDisponibles,
            // Otras configuraciones como 'sort' y 'pagination' si son necesarias
        ]);
        
        if (\Yii::$app->request->isGet) {
            $torneoId = \Yii::$app->request->get('torneoId');
            print( $torneoId);
            
            if ($torneoId) {
                // Añade la relación equipo-torneo
                \Yii::$app->db->createCommand()->insert('torneo_equipo', [
                    'equipo_id' => $id,
                    'torneo_id' => $torneoId,
                ])->execute();
    
                // Redirige a la vista del equipo o a otra página según sea necesario
                return $this->redirect(['view', 'id' => $id]);
            }
        }

        return $this->render('add-torneo', [
            'model' => $model,
            'equipo' => $equipo,
            'torneosDisponibles' => $torneosDisponibles,
            'clonesIds' => $clonesIds,
            'listaTorneos' => $listaTorneos,
            'torneoModel' => $torneoModel,
        ]);
    }

    public function actionSalirTorneo($torneoId, $equipoId)
    {
        // Aquí va la lógica para eliminar la relación entre el equipo y el participante
        \Yii::$app->db->createCommand()->delete('torneo_equipo', [
            'torneo_id' => $torneoId,
            'equipo_id' => $equipoId,
        ])->execute();

        return $this->redirect(['view', 'id' => $equipoId]);
    }

    /**
     * Deletes an existing Equipo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        \Yii::$app->db->createCommand()->update('premio', ['equipo_id' => null], ['equipo_id' => $id])->execute();

        $equipo = $this->findModel($id);

        // Verificar la inscripción en torneos y su estado
        $puedeEliminar = true;
        $fechaActual = new \DateTime();
        $fechaActualString = $fechaActual->format('Y-m-d H:i:s'); // Convierte a formato 'YYYY-MM-DD HH:MM:SS'     
        foreach ($equipo->torneos as $torneo) {
            // Comprobar si fecha_fin es nula o si el timestamp actual es menor que fecha_fin
            if ($torneo->fecha_fin === null || $fechaActualString < $torneo->fecha_fin) {
                $puedeEliminar = false;
                break;
            }
        }

        if (!$puedeEliminar) {
            \Yii::$app->session->setFlash('error', 'El equipo está inscrito en un torneo que aún no ha finalizado.');
            return $this->redirect(['index']);
        }

        // Eliminar registros en partido_equipo
        \Yii::$app->db->createCommand()->delete('partido_equipo', ['equipo_id' => $id])->execute();

        // Eliminar el equipo de torneo_equipo
        \Yii::$app->db->createCommand()->delete('torneo_equipo', ['equipo_id' => $id])->execute();

        // Eliminar los jugadores asociados al equipo en equipo_participante
        \Yii::$app->db->createCommand()->delete('equipo_participante', ['equipo_id' => $id])->execute();

        // Eliminar el equipo
        $equipo->delete();

        \Yii::$app->session->setFlash('success', 'Equipo eliminado con éxito.');
        return $this->redirect(['index']);
    }

   

    /**
     * Finds the Equipo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Equipo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Equipo::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}


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
     * Este método sobrescribe el método behaviors() de la clase base para configurar
     * los comportamientos (behaviors) de este controlador.
     *
     * @return array la configuración de comportamientos
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),  // Incluye los comportamientos de la clase base

            // Configuración del filtro de verbos (VerbFilter)
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ],

            // Configuración del control de acceso (AccessControl)
            [
                'access' => [
                    'class' => \yii\filters\AccessControl::class,
                    'rules' => [

                        // Regla 1: Permite el acceso a la acción 'index' para los roles 'sysadmin', 'admin' y 'gestor'
                        [
                            'actions' => ['index'],
                            'allow' => true,
                            'roles' => ['sysadmin','admin', 'gestor'],
                        ],

                        // Regla 2: Permite el acceso a múltiples acciones para roles 'sysadmin', 'admin', 'gestor' y 'usuario'
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
     * Lista todos los modelos de Equipo.
     *
     * @return string
     */
    public function actionIndex()
    {
        // Crea una nueva instancia de búsqueda para Equipo
        $searchModel = new EquipoSearch();
        // Obtiene los datos del proveedor a partir de los parámetros de la solicitud
        $dataProvider = $searchModel->search($this->request->queryParams);

        // Renderiza la vista 'index' pasando los modelos de búsqueda y datos del proveedor
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Asigna un líder a un equipo específico.
     * 
     * @param int $equipoId ID del equipo.
     * @param int $participante_id ID del participante a asignar como líder.
     * @return \yii\web\Response
     */
    public function actionLider($equipoId, $participante_id)
    {
        // Encuentra el modelo de Equipo basado en su ID
        $equipo = $this->findModel($equipoId);
        // Actualiza el campo 'creador_id' en la base de datos para el equipo especificado
        \Yii::$app->db->createCommand()->update('equipo', 
            ['creador_id' => $participante_id,],
            ['id' => $equipoId, ])->execute();
        // Redirecciona a la vista 'view' del equipo
        return $this->redirect(['view', 'id' => $equipoId]);
    }

    /**
     * Muestra un solo modelo de Equipo.
     * @param int $id ID del equipo.
     * @return string
     * @throws NotFoundHttpException si el modelo no se encuentra
     */
    public function actionView($id)
    {
        // Encuentra el modelo de Equipo basado en su ID
        $model = $this->findModel($id);
        $equipo = $this->findModel($id);

        // Encuentra el participante de la sesión actual
        $participanteSesion = Participante::findOne(['usuario_id' => \Yii::$app->user->id]);

        // Busca IDs de equipos 'clones' (mismos nombre, descripción, licencia y categoría)
        $clonesIds = Equipo::find()
            ->select('id')
            ->where(['nombre' => $model->nombre, 'descripcion' => $model->descripcion,'licencia' => $model->licencia,'categoria_id' => $model->categoria_id])
            ->column();

        // Obtiene la fecha y hora actual
        $fechaActual = new \DateTime();
        $fechaActualString = $fechaActual->format('Y-m-d H:i:s');

        // Encuentra torneos finalizados asociados a los equipos clones
        $torneosFinalizados = (new \yii\db\Query())
            ->select('torneo.*')
            ->from('torneo')
            ->leftJoin('torneo_equipo', 'torneo.id =torneo_equipo.torneo_id')
            ->where(['<', 'fecha_fin', $fechaActualString])
            ->andWhere(['IN', 'torneo_equipo.equipo_id', $clonesIds])
            ->all();
            // Determina si existen torneos finalizados
        $tieneTorneosFin = count($torneosFinalizados) > 0;

        // Encuentra torneos en curso asociados a los equipos clones
        $torneosEnCurso = (new \yii\db\Query())
            ->select('torneo.*')
            ->from('torneo')
            ->leftJoin('torneo_equipo', 'torneo.id = torneo_equipo.torneo_id')
            ->where(['AND',
                ['<', 'fecha_limite', $fechaActualString],
                ['OR', 
                    ['>', 'fecha_fin', $fechaActualString],
                    ['fecha_fin' => null]
                ]
            ])
            ->andWhere(['IN', 'torneo_equipo.equipo_id', $clonesIds])
            ->all();

        // Determina si existen torneos en curso
        $tieneTorneosCurso = count($torneosEnCurso) > 0;

        // Encuentra torneos en inscripción asociados a los equipos clones
        $torneosEnInscripcion = (new \yii\db\Query())
            ->select('torneo.*')
            ->from('torneo')
            ->leftJoin('torneo_equipo', 'torneo.id = torneo_equipo.torneo_id')
            ->where(['>', 'fecha_limite', $fechaActualString])
            ->andWhere(['IN', 'torneo_equipo.equipo_id', $clonesIds])
            ->all();

        // Determina si existen torneos en inscripción
        $tieneEnInscripcion = count($torneosEnInscripcion) > 0;

        // Consulta para obtener participantes del equipo
        $query = Participante::find()
            ->joinWith(['usuario', 'tipoParticipante'])
            ->innerJoin('equipo_participante', 'equipo_participante.participante_id = participante.id')
            ->where(['equipo_participante.equipo_id' => $id]);

        // Prepara el proveedor de datos para los participantes
        $dataProvider = new \yii\data\ActiveDataProvider(['query' => $query]);

        // Determina si existen participantes en el equipo
        $tieneParticipantes = $query->count() > 0;

        // Obtiene el usuario asociado al modelo de Equipo
        $usuario = $model->getUsuario()->one();

        // Renderiza la vista 'view' con todos los datos recopilados
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
     * Crea un nuevo modelo de Equipo.
     * Si la creación es exitosa, el navegador se redirigirá a la página 'view'.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        // Instancia un nuevo modelo de Equipo
        $model = new Equipo();
        
        // Obtiene todas las categorías y las ordena por nombre
        $categorias = Categoria::find()
            ->orderBy('nombre')
            ->all();

        // Obtiene todos los participantes, incluyendo la información de usuario, y los ordena por nombre
        $participantes = Participante::find()
            ->joinWith('usuario')
            ->orderBy('nombre')
            ->all();

        // Convierte las categorías en un array para su uso en un dropdown, usando 'id' como clave y 'nombre' como valor
        $listaCategorias = ArrayHelper::map($categorias, 'id', 'nombre');

        // Convierte los participantes en un array para su uso en un dropdown, usando 'id' como clave y el nombre del usuario como valor
        $listaParticipantes = ArrayHelper::map($participantes, 'id', 'usuario.nombre');
        
        // Encuentra el participante de la sesión actual
        $participanteSesion = Participante::findOne(['usuario_id' => \Yii::$app->user->id]);

        // Comprueba si la solicitud es de tipo POST (envío de formulario)
        if ($this->request->isPost) {
            // Carga los datos enviados en el modelo y guarda el modelo en la base de datos
            if ($model->load($this->request->post()) && $model->save()) {
                // Si se asignó un creador, inserta una relación en la tabla 'equipo_participante'
                if($model->creador_id != null){
                    \Yii::$app->db->createCommand()->insert('equipo_participante', [
                        'equipo_id' => $model->id,
                        'participante_id' => $model->creador_id,
                    ])->execute();
                }
                // Redirige a la página de vista del equipo
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            // Carga valores predeterminados si no es una solicitud POST
            $model->loadDefaultValues();
        }

        // Renderiza la vista 'create' con los datos necesarios
        return $this->render('create', [
            'model' => $model,
            'participanteSesion' => $participanteSesion,
            'listaCategorias' => $listaCategorias, // Pasa la lista de categorías a la vista
            'listaParticipantes' => $listaParticipantes,
            'participantes' => $participantes,
        ]);
    }

    /**
     * Actualiza un modelo de Equipo existente.
     * Si la actualización es exitosa, el navegador se redirigirá a la página 'view'.
     * @param int $id ID del modelo de Equipo a actualizar.
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException si el modelo no se puede encontrar.
     */
    public function actionUpdate($id)
    {
        // Encuentra el modelo de Equipo basado en su ID
        $model = $this->findModel($id);
        $equipo = $this->findModel($id);
        // Encuentra el participante de la sesión actual
        $participanteSesion = Participante::findOne(['usuario_id' => \Yii::$app->user->id]);

        // Obtiene todos los participantes, incluyendo la información de usuario, y los ordena por nombre
        $participantes = Participante::find()
                ->joinWith('usuario')
                ->orderBy('nombre')
                ->all();

        // Convierte los participantes en un array para su uso en un dropdown, usando 'id' como clave y el nombre del usuario como valor
        $listaParticipantes = ArrayHelper::map($participantes, 'id', 'usuario.nombre');

        // Logica de clonación
        if ((!\Yii::$app->user->can('gestor'))&&(!\Yii::$app->user->can('organizador'))&&(!\Yii::$app->user->can('sysadmin'))&&(\Yii::$app->user->can('usuario'))) 
        { 
            // Verifica si el equipo está inscrito en algún torneo
            $inscritoEnTorneos = (new \yii\db\Query())
                ->from('torneo_equipo')
                ->where(['equipo_id' => $id])
                ->exists();
            
            if ($inscritoEnTorneos) {
                // Clona el equipo si está inscrito en torneos
                $nuevoEquipo = new Equipo();
                $nuevoEquipo->attributes = $model->attributes; // Copia los atributos del equipo actual
                $nuevoEquipo->save(false); // Guarda el nuevo equipo sin validación

                // Obtiene los ID de los participantes actuales del equipo
                $participantesActuales = (new \yii\db\Query())
                    ->select('participante_id')
                    ->from('equipo_participante')
                    ->where(['equipo_id' => $id])
                    ->column();

                // Clona las relaciones con los participantes parael nuevo equipo
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

        // Obtiene todas las categorías y las ordena por nombre
        $categorias = Categoria::find()
            ->orderBy('nombre')
            ->all();

        // Convierte las categorías en un array para su uso en un dropdown, usando 'id' como clave y 'nombre' como valor
        $listaCategorias = ArrayHelper::map($categorias, 'id', 'nombre');

        // Obtiene participantes del equipo a través de una consulta
        $query = Participante::find()
            ->joinWith(['usuario', 'tipoParticipante'])
            ->innerJoin('equipo_participante', 'equipo_participante.participante_id = participante.id')
            ->where(['equipo_participante.equipo_id' => $id]);

        // Prepara el proveedor de datos para los participantes
        $dataProvider = new \yii\data\ActiveDataProvider(['query' => $query]);
        // Determina si el equipo tiene participantes
        $tieneParticipantes = $query->count() > 0;

        // Obtiene el usuario asociado al modelo de Equipo
        $usuario = $model->getUsuario()->one();

        // Verifica si la solicitud es POST y carga los datos en el modelo para guardarlos
        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            // Redirige a la vista del equipo
            return $this->redirect(['view', 'id' => $model->id]);
        }


        // Renderiza la vista 'update' con todos los datos necesarios
        return $this->render('update', [
            'model' => $model, // Pasa el modelo de Equipo a la vista
            'usuario' => $usuario, // Pasa la información del usuario asociado al equipo
            'equipo' => $equipo, // Pasa la información del equipo
            'participanteSesion' => $participanteSesion, // Pasa la información del participante de la sesión actual
            'listaParticipantes' => $listaParticipantes, // Pasa la lista de participantes para el dropdown
            'listaCategorias' => $listaCategorias, // Pasa la lista de categorías para el dropdown
            'dataProvider' => $dataProvider, // Proveedor de datos para los participantes del equipo
            'tieneParticipantes' => $tieneParticipantes, // Indica si el equipo tiene participantes
        ]);
    }

    /**
     * Agrega un participante a un equipo.
     * @param int $id ID del equipo al que se agregará el participante.
     * @return string|\yii\web\Response
     */
    public function actionAddParticipante($id)
    {
        // Encuentra el modelo de Equipo basado en su ID
        $equipo = $this->findModel($id);
        // Crea una nueva instancia del modelo Participante
        $participanteModel = new Participante();

        // Obtiene los ID de los participantes que ya están en el equipo
        $participantesEnEquipo = ArrayHelper::map($equipo->participantes, 'id', 'id');

        // Filtra y obtiene participantes que no están en el equipo, incluyendo su nombre y email
        $participantesDisponibles = Participante::find()
            ->joinWith('usuario') // Asegúrate de que la relación 'usuario' esté definida en el modelo Participante
            ->where(['NOT IN', 'participante.id', $participantesEnEquipo])
            ->all();
        // Prepara un array de participantes disponibles para mostrar en un dropdown
        $listaParticipantes = ArrayHelper::map($participantesDisponibles, 'id', function ($participante) {
            return $participante->usuario->nombre . ' (' . $participante->usuario->email . ')';
        });

        // Comprueba si la solicitud es de tipo POST    
        if (\Yii::$app->request->isPost) {
            // Obtiene el ID del participante enviado a través del formulario
            $participanteId = \Yii::$app->request->post('Participante')['id'];
            // Verifica si el participante seleccionado no está ya en el equipo
            if ($participanteId && !in_array($participanteId, $participantesEnEquipo)) {
                // Lógica para añadir el participante al equipo
                \Yii::$app->db->createCommand()->insert('equipo_participante', [
                    'equipo_id' => $id,
                    'participante_id' => $participanteId,
                ])->execute();
        
                // Redirige a la vista del equipo
                return $this->redirect(['view', 'id' => $id]);
            }
        }
        // Renderiza la vista 'add-participante' con los datos necesarios
        return $this->render('add-participante', [
            'equipo' => $equipo, // Pasa la información del equipo a la vista
            'participanteModel' => $participanteModel, // Pasa el modelo de Participante a la vista
            'listaParticipantes' => $listaParticipantes, // Pasa la lista de participantes disponibles a la vista
        ]);
    }
    
    /**
     * Expulsa un participante de un equipo.
     * @param int $equipoId ID del equipo del cual se expulsará el participante.
     * @param int $participanteId ID del participante a expulsar.
     * @return \yii\web\Response
     */
    public function actionExpulsarParticipante($equipoId, $participanteId)
    {
        // Busca el equipo basado en el ID proporcionado
        $equipo  = (Equipo::findOne($equipoId));
        
        // Verifica si el participante a expulsar es el creador del equipo
        if($equipo->creador_id  == $participanteId)
        {
            // Cuenta otros participantes en el equipo que no sean el participante a expulsar
            $otrosParticipantes = \Yii::$app->db->createCommand('SELECT participante_id FROM equipo_participante WHERE equipo_id = :equipoId AND participante_id != :participanteId')
                ->bindValue(':equipoId', $equipoId)
                ->bindValue(':participanteId', $participanteId)
                ->queryAll();

            if (!empty($otrosParticipantes)) {
                // Si hay otros participantes, selecciona uno como nuevo creador
                $nuevoCreadorId = $otrosParticipantes[0]['participante_id'];
                $equipo->creador_id = $nuevoCreadorId;
            } else {
                // Si no hay otros participantes, establece el creador_id a null
                $equipo->creador_id = null;
            } 
            // Guarda los cambios en el modelo del equipo
            $equipo->save();   
        }
        
        // Elimina la relación entre el participante y el equipo en la base de datos
        \Yii::$app->db->createCommand()->delete('equipo_participante', [
            'equipo_id' => $equipoId,
            'participante_id' => $participanteId,
        ])->execute();

        // Redirige a la página de actualización del equipo
        return $this->redirect(['update', 'id' => $equipoId]);
    }

    /**
     * Agrega un torneo a un equipo.
     * @param int $id ID del equipo al cual se añadirá el torneo.
     * @return string|\yii\web\Response
     */
    public function actionAddTorneo($id)
    {
        // Busca el modelo de Equipo basado en su ID
        $model = $this->findModel($id);
        $equipo = $this->findModel($id);
        // Crea una nueva instancia del modelo Torneo
        $torneoModel = new Torneo();

        // Encuentra todos los equipos que son 'clones' del equipo actual
        $clonesIds = Equipo::find()
            ->where(['nombre' => $model->nombre, 'descripcion' => $model->descripcion, 'licencia' => $model->licencia, 'categoria_id' => $model->categoria_id])
            ->select('id')
            ->column();

        // Obtiene la fecha y hora actual
        $fechaActual = new \DateTime();
        $fechaActualString = $fechaActual->format('Y-m-d H:i:s');

        // Encuentra los torneos disponibles para inscribirse, excluyendo aquellos en los que ya está inscrito el equipo o sus clones
        $torneosDisponibles = (new \yii\db\Query())
            ->select([
                'torneo.*',
                // Cuenta la cantidad de equipos inscritos en cada torneo
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

        // Prepara un proveedor de datos para la lista de torneos disponibles
        $listaTorneos = new \yii\data\ArrayDataProvider([
            'allModels' => $torneosDisponibles,
            // Aquí puedes agregar configuraciones adicionales como 'sort' y 'pagination'
        ]);
        
        // Comprueba si la solicitud es de tipo GET
        if (\Yii::$app->request->isGet) {
            // Obtiene el ID del torneo seleccionado
            $torneoId = \Yii::$app->request->get('torneoId');

            if ($torneoId) {
                // Añade la relaciónequipo-torneo en la base de datos
                \Yii::$app->db->createCommand()->insert('torneo_equipo', [
                    'equipo_id' => $id,
                    'torneo_id' => $torneoId,
                ])->execute();
                // Redirige a la vista del equipo o a otra página según sea necesario
                return $this->redirect(['view', 'id' => $id]);
            }
        }

        // Renderiza la vista 'add-torneo' con los datos necesarios
        return $this->render('add-torneo', [
            'model' => $model, // Pasa el modelo del equipo a la vista
            'equipo' => $equipo, // Pasa la información del equipo a la vista
            'torneosDisponibles' => $torneosDisponibles, // Pasa la lista de torneos disponibles a la vista
            'clonesIds' => $clonesIds, // Pasa los ID de los equipos clones
            'listaTorneos' => $listaTorneos, // Pasa el proveedor de datos de los torneos a la vista
            'torneoModel' => $torneoModel, // Pasa el modelo de Torneo a la vista
        ]);    
    }
    
    /**
     * Elimina la participación de un equipo en un torneo específico.
     * @param int $torneoId ID del torneo del cual se retirará el equipo.
     * @param int $equipoId ID del equipo que se retirará del torneo.
     * @return \yii\web\Response
     */
    public function actionSalirTorneo($torneoId, $equipoId)
    {
        // Elimina la relación entre el equipo y el torneo en la base de datos
        \Yii::$app->db->createCommand()->delete('torneo_equipo', [
            'torneo_id' => $torneoId,
            'equipo_id' => $equipoId,
        ])->execute();

        // Redirige a la vista del equipo
        return $this->redirect(['view', 'id' => $equipoId]);
    }

   /**
     * Elimina un modelo de Equipo existente.
     * Si la eliminación es exitosa, el navegador se redirigirá a la página 'index'.
     * @param int $id ID del equipo a eliminar.
     * @return \yii\web\Response
     * @throws NotFoundHttpException si el modelo no se puede encontrar.
     */
    public function actionDelete($id)
    {
        // Actualiza la tabla 'premio', estableciendo a null el 'equipo_id' para el equipo que se va a eliminar
        \Yii::$app->db->createCommand()->update('premio', ['equipo_id' => null], ['equipo_id' => $id])->execute();

        // Encuentra el modelo de Equipo basado en su ID
        $equipo = $this->findModel($id);

        // Verifica si el equipo está inscrito en torneos que aún no han finalizado
        $puedeEliminar = true;
        $fechaActual = new \DateTime();
        $fechaActualString = $fechaActual->format('Y-m-d H:i:s'); // Convierte a formato 'YYYY-MM-DD HH:MM:SS'     
        foreach ($equipo->torneos as $torneo) {
            // Comprueba si el torneo aún está en curso
            if ($torneo->fecha_fin === null || $fechaActualString < $torneo->fecha_fin) {
                $puedeEliminar = false;
                break;
            }
        }
        // Encuentra el participante de la sesión actual
        $participanteSesion = Participante::findOne(['usuario_id' => \Yii::$app->user->id]);

        // Si el equipo está inscrito en un torneo en curso, impide su eliminación y muestra un mensaje de error
        if (!$puedeEliminar) {
            if ((!\Yii::$app->user->can('gestor'))&&(!\Yii::$app->user->can('organizador'))&&(!\Yii::$app->user->can('sysadmin'))&&(\Yii::$app->user->can('usuario'))) 
            { 
                \Yii::$app->session->setFlash('error', 'El equipo está inscrito en un torneo que aún no ha finalizado.');
                return $this->redirect(['participante/view','id' => $participanteSesion->id]);
            }else{
                \Yii::$app->session->setFlash('error', 'El equipo está inscrito en un torneo que aún no ha finalizado.');
                return $this->redirect(['index']);
            }
        }

        // Elimina las relaciones del equipo en la tabla 'partido_equipo'
        \Yii::$app->db->createCommand()->delete('partido_equipo', ['equipo_id' => $id])->execute();

        // Elimina las relaciones del equipo en la tabla 'torneo_equipo'
        \Yii::$app->db->createCommand()->delete('torneo_equipo', ['equipo_id' => $id])->execute();
        // Elimina las relaciones de los jugadores con el equipo en la tabla 'equipo_participante'
        \Yii::$app->db->createCommand()->delete('equipo_participante', ['equipo_id' => $id])->execute();

        // Finalmente, elimina el equipo
        $equipo->delete();

        if ((!\Yii::$app->user->can('gestor'))&&(!\Yii::$app->user->can('organizador'))&&(!\Yii::$app->user->can('sysadmin'))&&(\Yii::$app->user->can('usuario'))) 
        { 
            // Muestra un mensaje de éxito tras la eliminación exitosa del equipo
            \Yii::$app->session->setFlash('success', 'Equipo eliminado con éxito.');
            return $this->redirect(['participante/view','id' => $participanteSesion->id]);             
        }else{
            // Muestra un mensaje de éxito tras la eliminación exitosa del equipo
            \Yii::$app->session->setFlash('success', 'Equipo eliminado con éxito.');
            return $this->redirect(['index']); 
        }
    }       

   /**
     * Encuentra el modelo de Equipo basado en su clave primaria.
     * Si el modelo no se encuentra, se lanzará una excepción HTTP 404.
     * @param int $id ID del modelo de Equipo a encontrar.
     * @return Equipo el modelo cargado
     * @throws NotFoundHttpException si el modelo no se puede encontrar
     */
    protected function findModel($id)
    {
        // Intenta encontrar el modelo de Equipo utilizando el ID proporcionado
        if (($model = Equipo::findOne(['id' => $id])) !== null) {
            // Si se encuentra el modelo, lo devuelve
            return $model;
        }

        // Si el modelo no se encuentra, lanza una excepción NotFoundHttpException
        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
  
}


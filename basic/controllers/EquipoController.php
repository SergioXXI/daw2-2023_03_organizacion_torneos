<?php

namespace app\controllers;

use app\models\Equipo;
use app\models\Participante;
use app\models\Categoria;
use app\models\EquipoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;


/**
 * EquipoController implements the CRUD actions for Equipo model.
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

    /**
     * Displays a single Equipo model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {

        $model = $this->findModel($id);

        // Obtener participantes del equipo
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => Participante::find()
                ->joinWith(['usuario', 'tipoParticipante'])
                ->innerJoin('equipo_participante', 'equipo_participante.participante_id = participante.id')
                ->where(['equipo_participante.equipo_id' => $id]),
        ]);


        return $this->render('view', [
            'model' => $model,
            'dataProvider' => $dataProvider,
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

        // Convertir a un array para el desplegable, usando 'id' como clave y 'nombre' como valor
        $listaCategorias = ArrayHelper::map($categorias, 'id', 'nombre');

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'listaCategorias' => $listaCategorias, // Pasar la lista de categorías a la vista
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

            // Clonar las relaciones con los participantes
            foreach ($model->participantes as $participante) {
                $nuevaRelacion = new EquipoParticipante();
                $nuevaRelacion->equipo_id = $nuevoEquipo->id;
                $nuevaRelacion->participante_id = $participante->id;
                $nuevaRelacion->save(false);
            }

            // Redirige a la acción de actualizar para el nuevo equipo clonado
            return $this->redirect(['update', 'id' => $nuevoEquipo->id]);
        }

       

        // Obtener todas las categorías
        $categorias = Categoria::find()
            ->orderBy('nombre')
            ->all();

        // Convertir a un array para el desplegable, usando 'id' como clave y 'nombre' como valor
        $listaCategorias = ArrayHelper::map($categorias, 'id', 'nombre');

        // Obtener participantes del equipo
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => Participante::find()
                ->joinWith(['usuario', 'tipoParticipante'])
                ->innerJoin('equipo_participante', 'equipo_participante.participante_id = participante.id')
                ->where(['equipo_participante.equipo_id' => $id]),
        ]);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'listaCategorias' => $listaCategorias,
            'dataProvider' => $dataProvider,
        ]);
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
        $equipo = $this->findModel($id);
        // Verificar la inscripción en torneos y su estado
        $puedeEliminar = true;
        $fechaActual = time(); // Obtiene el timestamp actual
        foreach ($equipo->torneos as $torneo) {
            // Comprobar si fecha_fin es nula o si el timestamp actual es menor que fecha_fin
            if ($torneo->fecha_fin === null || $fechaActual < $torneo->fecha_fin) {
                $puedeEliminar = false;
                break;
            }
        }

        if (!$puedeEliminar) {
            \Yii::$app->session->setFlash('error', 'El equipo está inscrito en un torneo que aún no ha finalizado.');
            return $this->redirect(['index']);
        }

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

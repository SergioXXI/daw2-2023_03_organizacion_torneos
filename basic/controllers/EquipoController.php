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
        $participantes = Participante::find()
            ->joinWith('usuario') // Asumiendo que existe una relación con 'usuario'
            ->where(['equipo_id' => $id])
            ->all();

        return $this->render('view', [
            'model' => $model,
            'participantes' => $participantes,
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

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
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
        \Yii::$app->db->createCommand()->update('premio', ['equipo_id' => null], ['equipo_id' => $id])->execute();

        $equipo = $this->findModel($id);
        // Verificar la inscripción en torneos y su estado
        $puedeEliminar = true;
        foreach ($equipo->torneos as $torneo) {
            if ($torneo->fecha_fin === null) {
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

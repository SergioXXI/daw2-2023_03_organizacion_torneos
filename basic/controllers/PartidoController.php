<?php

namespace app\controllers;

use Yii;
use app\models\Partido;
use app\models\PartidoSearch;
use app\models\PartidoEquipo;
use app\models\ResultadoForm; // Add this import statement
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PartidoController implements the CRUD actions for Partido model.
 */
class PartidoController extends Controller
{

    public function actualizarResultado($idPartido, $idEquipo, $puntos)
    {
        $partidoEquipo = PartidoEquipo::findOne(['partido_id' => (int)$idPartido, 'equipo_id' => (int)$idEquipo]);
        $partidoEquipo->puntos = $puntos;
        $partidoEquipo->save();
    }

    public function actionActualizarResultado()
    {
        // $idPartido = $this->request->get('idPartido');
        $model = new ResultadoForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $this->actualizarResultado($model->idPartido, $model->idEquipo1, $model->puntosEquipo1);
            $this->actualizarResultado($model->idPartido, $model->idEquipo2, $model->puntosEquipo2);
            Yii::$app->session->setFlash('success', 'Resultados actualizados exitosamente.');
            
            return $this->render('view', [
                'model' => $this->findModel($model->idPartido),
            ]);
        }

        return $this->render('actualizarResultado', [
            'model' => $model,
        ]);
    }



    /**
     * Lists all Partido models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PartidoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Partido model.
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

    /**
     * Creates a new Partido model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Partido();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['equipos_partidos', 'id_partido' => $model->id,'id_torneo' => $model->torneo_id]);  
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Partido model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['equipos_partidos', 'id_partido' => $model->id,'id_torneo' => $model->torneo_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Partido model.
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
     * Finds the Partido model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Partido the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Partido::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionEquipos_partidos($id_partido,$id_torneo)
    {
        $model_equipo1 = new PartidoEquipo();
        $model_equipo2 = new PartidoEquipo();

        if ($this->request->isPost && $model_equipo1->load($this->request->post())  && $model_equipo2->load($this->request->post()) ) {
            $model_equipo1->partido_id=$id_partido;
            $model_equipo1->puntos=0;
            $model_equipo2->partido_id=$id_partido;
            $model_equipo2->puntos=0;
            $model_equipo1->save();
            $model_equipo2->save();
            return $this->redirect(['index']);
        }
        return $this->render('equipos_partidos', [
            'id' => $id_torneo,
            'model_equipo1' => $model_equipo1,
            'model_equipo2' => $model_equipo2,
        ]);
    }

    public function actionGenerar_reserva($id)
    {
        // Obtener el objeto de sesión
        $session = Yii::$app->session;

        // Abre la sesión si aún no está abierta
        if (!$session->isActive) {
            $session->open();
        }
        $session->set('id_partido', $id );
        return $this->redirect(['pista/pistas']);
    }
}

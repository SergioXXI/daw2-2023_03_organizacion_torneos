<?php

namespace app\controllers;

use app\models\Equipo;
use app\models\Partido;
use app\models\PartidoEquipo;
use app\models\PartidoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PartidoController implements the CRUD actions for Partido model.
 */
class PartidoController extends Controller
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
            return $this->redirect(['view', 'id' => $model->id]);
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
}

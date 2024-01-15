<?php

namespace app\controllers;

use app\models\ReservaPista;
use app\models\ReservaPistaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use Yii;

/**
 * ReservaPistaController implements the CRUD actions for ReservaPista model.
 */
class ReservaPistaController extends Controller
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
     * Lists all ReservaPista models.
     *
     * @return string
     */
    public function actionIndex()
    {
        //Creación del nuevo modelo de busqueda y uso mediante los parametros llegados por Get
        $searchModel = new ReservaPistaSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ReservaPista model.
     * @param int $reserva_id Reserva ID
     * @param int $pista_id Pista ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($reserva_id, $pista_id)
    {
        $model = $this->findModel($reserva_id, $pista_id);
        //Obtener los modelos pista y reserva para mostrar su información
        $pista = $model->pista;
        $reserva = $model->reserva;

        return $this->render('view', [
            'model' => $model,
            'pista' => $pista,
            'reserva' => $reserva,
        ]);
    }

    /**
     * Creates a new ReservaPista model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new ReservaPista();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'reserva_id' => $model->reserva_id, 'pista_id' => $model->pista_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ReservaPista model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $reserva_id Reserva ID
     * @param int $pista_id Pista ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     * 
     * No se va a permitir editar esta tabla
     */
    /* public function actionUpdate($reserva_id, $pista_id)
    {
        $model = $this->findModel($reserva_id, $pista_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'reserva_id' => $model->reserva_id, 'pista_id' => $model->pista_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    } */

    /**
     * Deletes an existing ReservaPista model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $reserva_id Reserva ID
     * @param int $pista_id Pista ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($reserva_id, $pista_id)
    {
        $this->findModel($reserva_id, $pista_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ReservaPista model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $reserva_id Reserva ID
     * @param int $pista_id Pista ID
     * @return ReservaPista the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($reserva_id, $pista_id)
    {
        if (($model = ReservaPista::findOne(['reserva_id' => $reserva_id, 'pista_id' => $pista_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}

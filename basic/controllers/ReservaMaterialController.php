<?php

namespace app\controllers;

use app\models\ReservaMaterial;
use app\models\ReservaMaterialSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ReservaMaterialController implements the CRUD actions for ReservaMaterial model.
 */
class ReservaMaterialController extends Controller
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
                            'actions' => ['index', 'view'],
                            'allow' => true,
                            'roles' => ['sysadmin','admin',  'organizador'],
                        ],
                        [
                            'actions' => ['create', 'update', 'delete','asignar_ganador'],
                            'allow' => true,
                            'roles' => ['sysadmin','admin','organizador'],
                        ],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all ReservaMaterial models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ReservaMaterialSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ReservaMaterial model.
     * @param int $reserva_id Reserva ID
     * @param int $material_id Material ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($reserva_id, $material_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($reserva_id, $material_id),
        ]);
    }

    /**
     * Creates a new ReservaMaterial model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new ReservaMaterial();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'reserva_id' => $model->reserva_id, 'material_id' => $model->material_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ReservaMaterial model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $reserva_id Reserva ID
     * @param int $material_id Material ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($reserva_id, $material_id)
    {
        $model = $this->findModel($reserva_id, $material_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'reserva_id' => $model->reserva_id, 'material_id' => $model->material_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ReservaMaterial model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $reserva_id Reserva ID
     * @param int $material_id Material ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($reserva_id, $material_id)
    {
        $this->findModel($reserva_id, $material_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ReservaMaterial model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $reserva_id Reserva ID
     * @param int $material_id Material ID
     * @return ReservaMaterial the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($reserva_id, $material_id)
    {
        if (($model = ReservaMaterial::findOne(['reserva_id' => $reserva_id, 'material_id' => $material_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}

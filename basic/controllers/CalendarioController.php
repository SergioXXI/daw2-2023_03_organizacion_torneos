<?php

namespace app\controllers;

use app\models\Torneo;
use app\models\TorneoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CalendarioController implements the CRUD actions for Torneo model.
 */
class CalendarioController extends Controller
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
     * Lists all Torneo models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TorneoSearch();

        //print_r($searchModel);

        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->pagination = false;

        //echo '<pre>';
        //print_r($dataProvider->getModels());
        return $this->render('index', [
            'searchModel' => $searchModel,
            'torneos' => $dataProvider,
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

<?php

namespace app\controllers;

use app\models\Torneo;
use app\models\Partido;
use app\models\TorneoSearch;
use app\models\PartidoSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;

use Yii;

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
        /* $sql = "
            SELECT *
            FROM torneo t
            LEFT JOIN partido p ON t.id = p.torneo_id
        ";

        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
            'totalCount' => (new Query())->select('COUNT(*)')->from(['t' => 'torneo'])->count(),
            'pagination' => false,
            // Other configuration options if needed
        ]);

        $count = \Yii::$app->db->createCommand('SELECT COUNT(*) FROM torneo t LEFT JOIN partido p ON t.id = p.torneo_id')->queryScalar();

        $eventos = new SqlDataProvider([
            'sql' => $sql,
            'totalCount' => $count,
            'sort' => [
                'defaultOrder' => [
                    'fecha_inicio' => SORT_ASC,
                ],
            ],
            'pagination' => [
                'pageSize' => \Yii::$app->params['limiteEventos'],
            ],
        ]); */

        $torneoSearch = new TorneoSearch();
        $torneos = $torneoSearch->search($this->request->queryParams);
        $torneos->sort->defaultOrder = ['fecha_inicio' => SORT_ASC];

        $partidoSearch = new PartidoSearch();
        $partidos = $partidoSearch->search($this->request->queryParams);
        $partidos->sort->defaultOrder = ['fecha' => SORT_ASC];

        /* $torneos = new ActiveDataProvider([
            'query' => Torneo::find(),
            'pagination' => false,
            'sort' => [
                'defaultOrder' => ['fecha_inicio' => SORT_ASC],
            ],
        ]);
        
        $partidos = new ActiveDataProvider([
            'query' => Partido::find(),
            'pagination' => false,
            'sort' => [
                'defaultOrder' => ['fecha' => SORT_ASC],
            ],
        ]); */

        $eventos = array_merge($torneos->models, $partidos->models);

        //Como se estan utilizando dos modelos distintos que no comparte un campo comun para ser ordenados
        //se va a utilizar la función usort y se van a ordenar los eventos en el caso de los partidos
        //mirando su fecha y en los torneos su fecha_inicio
        usort($eventos, function ($a, $b) {
            $fechaA = isset($a->fecha_inicio) ? $a->fecha_inicio : $a->fecha;
            $fechaB = isset($b->fecha_inicio) ? $b->fecha_inicio : $b->fecha;

            return strtotime($fechaA) - strtotime($fechaB);
        });

        $dataProvider = new ArrayDataProvider([
            'allModels' => $eventos,
            'pagination' => [
                'pageSize' => \Yii::$app->params['limiteEventos'],
            ],
        ]);


        return $this->render('index', [
            'eventosProvider' => $dataProvider,
            'torneoSearch' => $torneoSearch,
            'partidoSearch' => $partidoSearch,
        ]);
    }

    public function actionCalendario()
    {
        $searchModel = new TorneoSearch();

        //print_r($searchModel);

        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->pagination = false;

        //echo '<pre>';
        //print_r($dataProvider->getModels());
        return $this->render('calendario', [
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

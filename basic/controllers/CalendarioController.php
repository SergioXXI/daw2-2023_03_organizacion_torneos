<?php

namespace app\controllers;

use app\models\Torneo;
use app\models\Clase;
use app\models\Disciplina;
use app\models\Partido;
use app\models\TorneoSearch;
use app\models\PartidoSearch;
use app\models\CalendarioSearch;
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

        /* $torneoSearch = new TorneoSearch();
        $torneos = $torneoSearch->search($this->request->queryParams);
        $torneos->sort->defaultOrder = ['fecha_inicio' => SORT_ASC];
        $torneos->pagination = false;

        $partidoSearch = new PartidoSearch();
        $partidos = $partidoSearch->search($this->request->queryParams);
        $partidos->sort->defaultOrder = ['fecha' => SORT_ASC];
        $partidos->pagination = false; */

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


        /* $torneoSearch = new TorneoSearch();
        $partidoSearch = new PartidoSearch();

        $busquedaGlobal = Yii::$app->request->get('busquedaGlobal');
        if($busquedaGlobal === null) $busquedaGlobal = '';
        $torneoSearch->busquedaGlobal = $busquedaGlobal;
        $partidoSearch->busquedaGlobal = $busquedaGlobal;

        /* $partidoEvents = Partido::getFutureEvents();
        $torneoEvents = Torneo::getFutureEvents(); 

        $torneoProvider = $torneoSearch->searchEventos($this->request->queryParams);
        $partidoProvider = $partidoSearch->searchEventos($this->request->queryParams);

        $torneoProvider->pagination = false;
        $partidoProvider->pagination = false;

        $eventos = [];
        $fecha_actual = date('Y-m-d H:i:s');

        foreach($torneoProvider->models as $evento) {
            if($fecha_actual <= $evento->fecha_inicio)
                $eventos[] = [
                    'nombre' => 'Inicio de torneo ' . $evento->nombre,
                    'fecha' => $evento->fecha_inicio,
                    'clase_id' => Clase::find()->where(['id' => $evento->clase_id])->one()->titulo,
                ];
            if($fecha_actual <= $evento->fecha_limite)
            $eventos[] = [
                'nombre' => 'Fin de inscripciones para torneo ' . $evento->nombre,
                'fecha' => $evento->fecha_limite,
                'clase_id' => Clase::find()->where(['id' => $evento->clase_id])->one()->titulo,
            ];
            if(!empty($evento->fecha_limite) && $fecha_actual <= $evento->fecha_fin)
                $eventos[] = [
                    'nombre' => 'Finalización del torneo ' . $evento->nombre,
                    'fecha' => $evento->fecha_fin,
                    'clase_id' => Clase::find()->where(['id' => $evento->clase_id])->one()->titulo,
                ];
        }
        foreach($partidoProvider->models as $evento) {
            $torneo = $evento->torneo;
            $eventos[] = [
                'nombre' => $torneo->nombre . ' - Jornada ' . $evento->jornada,
                'fecha' => $evento->fecha,
            ];
        }

        //Como se estan utilizando dos modelos distintos que no comparte un campo comun para ser ordenados
        //se va a utilizar la función usort y se van a ordenar los eventos en el caso de los partidos
        //mirando su fecha y en los torneos su fecha_inicio
        usort($eventos, function($a, $b) {
            // Convert dates to timestamps for comparison
            $fechaA = strtotime($a['fecha']);
            $fechaB = strtotime($b['fecha']);
        
            // Compare timestamps
            return $fechaA - $fechaB;
        });

        $dataProvider = new ArrayDataProvider([
            'allModels' => $eventos,
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);


        return $this->render('index', [
            'eventosProvider' => $dataProvider,
            'torneoSearch' => $torneoSearch,
            'partidoSearch' => $partidoSearch,
        ]); */


        $torneoSearch = new TorneoSearch();
        $torneoProvider = $torneoSearch->searchEventos($this->request->queryParams);
        $torneoProvider->pagination = false;

        $eventos = [];
        $fecha_actual_h = date('Y-m-d H:i:s');
        $fecha_actual = date('Y-m-d');

        //Recorrer los modelos torneo obtenidos para generar un evento por cada fecha relevante
        //En este caso se generara un evento si la fecha comparada es mayor o igual a la fecha de hoy
        //Eventos a generar: inicio de torneo, fin de inscripciones de torneo, fin del torneo, partido del torneo
        foreach($torneoProvider->models as $evento) {
            $clase = Clase::find()->where(['id' => $evento->clase_id])->one()->titulo;
            $disciplina = Disciplina::find()->where(['id' => $evento->disciplina_id])->one()->nombre;
            
            if($fecha_actual_h <= $evento->fecha_inicio)
                $eventos[] = ['fecha' => $evento->fecha_inicio, 'nombre' => $evento->nombre, 'clase' => $clase, 'disciplina' => $disciplina, 'id' => $evento->id, 'tipo' => 'inicio'];

            if($fecha_actual_h <= $evento->fecha_limite)
                $eventos[] = ['fecha' => $evento->fecha_limite, 'nombre' => $evento->nombre, 'clase' => $clase, 'disciplina' => $disciplina, 'id' => $evento->id, 'tipo' => 'inscripcion'];
            
            if(!empty($evento->fecha_fin) && $fecha_actual_h <= $evento->fecha_fin)
                $eventos[] = ['fecha' => $evento->fecha_fin, 'nombre' => $evento->nombre, 'clase' => $clase, 'disciplina' => $disciplina, 'id' => $evento->id, 'tipo' => 'fin'];
            
            $partidos = $evento->partidos;
            if($partidos !== null) {
                foreach($partidos as $partido) {
                    if($fecha_actual <= $partido->fecha)
                        $eventos[] = ['fecha' => $partido->fecha, 'nombre' => $evento->nombre, 'clase' => $clase, 'disciplina' => $disciplina, 'id' => $partido->id, 'tipo' => 'partido', 'jornada' => $partido->jornada];
                }
            }
        }

        //Como se han creado diversos eventos a partir de un mismo torneo hay que reordenar el array
        //Para que todos salgan ordenados en función de sus correspondientes fechas
        usort($eventos, function($a, $b) {
            //Convertir las strings de fecha a numerico
            $fechaA = strtotime($a['fecha']);
            $fechaB = strtotime($b['fecha']);
            //Devolver la comparación entre ambas fechas
            return $fechaA - $fechaB;
        });

        //Generación de un ArrayDataProvider para poder gestionar los datos de los eventos generador
        //y poder paginarlos y suministrarlos a la vista index.php
        $dataProvider = new ArrayDataProvider([
            'allModels' => $eventos,
            'pagination' => [
                'pageSize' => Yii::$app->params['limiteEventos'],
            ],
        ]);

        return $this->render('index', [
            'eventosProvider' => $dataProvider,
            'torneoSearch' => $torneoSearch,
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

    public static function getTextoEvento($texto, $jornada = '')
    {
        $textoEvento = [
            'inicio' => 'Inicio de torneo',
            'inscripcion' => 'Fin de inscripción',
            'fin' => 'Finalización del torneo',
            'partido' => 'Partido jornada ' . $jornada,
        ];
        return $textoEvento[$texto];
    }
}

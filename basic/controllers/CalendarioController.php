<?php

namespace app\controllers;

use app\models\Torneo;
use app\models\Clase;
use app\models\Disciplina;
use app\models\TorneoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;

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

    /*
     * Función que se encarga de listar todos los eventos proximos de la web
     * Estos eventos son de 4 tipos: Jornada, Inicio, Fin, Fin inscripciones.
     * Cada evento representa algo importante que va a suceder en la página
     * Los tres eventos de Inicio, Fin, Fin inscripciones no existen como tal
     * en la base de datos, si no que se generan en función de dichas fechas de
     * cada torneo de la db.
     */
    public function actionIndex()
    {

        //Se filtran los torneos en función de los parámetros de busqueda
        $torneoSearch = new TorneoSearch();
        $torneoProvider = $torneoSearch->searchEventos($this->request->queryParams);
        $torneoProvider->pagination = false;

        //Se van a guardar los eventos creados a partir de cada modelo torneo en un array con propiedades
        //que puedan ser utilizadas posteriormente para mostrarse en formato tarjeta
        $eventos = [];
        $fecha_actual_h = date('Y-m-d H:i:s');
        $fecha_actual = date('Y-m-d');

        //Recorrer los modelos torneo obtenidos para generar un evento por cada fecha relevante
        //En este caso se generara un evento si la fecha comparada es mayor o igual a la fecha de hoy
        //Eventos a generar: inicio de torneo, fin de inscripciones de torneo, fin del torneo, partido del torneo
        foreach($torneoProvider->models as $evento) {
            //Obtencion de modelos relacionados con torneo para extraer información que se mostrará
            $clase = Clase::find()->where(['id' => $evento->clase_id])->one()->titulo;
            $disciplina = Disciplina::find()->where(['id' => $evento->disciplina_id])->one()->nombre;
            
            //Evento inicio de torneo
            if($fecha_actual_h <= $evento->fecha_inicio)
                $eventos[] = ['fecha' => $evento->fecha_inicio, 'nombre' => $evento->nombre, 'clase' => $clase, 'disciplina' => $disciplina, 'id' => $evento->id, 'tipo' => 'inicio'];

            //Evento fin de inscripciones de torneo
            if($fecha_actual_h <= $evento->fecha_limite)
                $eventos[] = ['fecha' => $evento->fecha_limite, 'nombre' => $evento->nombre, 'clase' => $clase, 'disciplina' => $disciplina, 'id' => $evento->id, 'tipo' => 'inscripcion'];
            
            //Evento fin de torneo si este tiene una fecha de fin
            if(!empty($evento->fecha_fin) && $fecha_actual_h <= $evento->fecha_fin)
                $eventos[] = ['fecha' => $evento->fecha_fin, 'nombre' => $evento->nombre, 'clase' => $clase, 'disciplina' => $disciplina, 'id' => $evento->id, 'tipo' => 'fin'];
            
            //Eventos para cada partido asociado al torneo
            $partidos = $evento->partidos;
            if($partidos !== null) {
                foreach($partidos as $partido) {
                    if($fecha_actual <= $partido->fecha)
                        $eventos[] = ['fecha' => $partido->fecha, 'nombre' => $evento->nombre, 'clase' => $clase, 'disciplina' => $disciplina, 'id' => $partido->id, 'tipo' => 'partido', 'jornada' => $partido->jornada];
                }
            }
        }

        //Como se han creado diversos eventos a partir de un mismo torneo hay que reordenar el array a partir de la fecha usada
        //para que todos salgan ordenados en función de sus correspondientes fechas
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

    /*
     * Función que se encarga de obtener todos los torneos para poder generar eventos en base a
     * esos torneos, en este caso, los eventos serán 3: Inicio, Fin y Fin inscripciones
     * Estos eventos serán visualizados en un calendario usando la libreria FullCalendar
     */
    public function actionCalendario()
    {
        //Obtener todos los torneos
        $torneos = Torneo::find()->all();

        //Generar los eventos indicados para cada torneo recorriendo todos los torneos
        //y obteniendo los datos necesarios para cada evento
        $eventos = [];
        foreach ($torneos as $torneo) {
	        $eventos[] = [
                'title' => 'Inicio - ' . Html::encode($torneo->nombre),
                'start' => Html::encode($torneo->fecha_inicio),
                'color' => 'green',
                'allDay' => true,
                'url' => Url::toRoute(['torneo/view', 'id' => $torneo->id]),
            ];

            $eventos[] = [
                'title' => 'Fin plazo - ' . Html::encode($torneo->nombre),
                'start' => Html::encode($torneo->fecha_limite),
                'color' => 'orange',
                'allDay' => true,
                'url' => Url::toRoute(['torneo/view', 'id' => $torneo->id]),
            ];

            //Si el torneo dispone de una fecha de fin también se incluira dicho evento
            if($torneo->fecha_fin !== null) {
                $eventos[] = [
                    'title' => 'Fin - ' . Html::encode($torneo->nombre),
                    'start' => Html::encode($torneo->fecha_fin),
                    'color' => 'indianred',
                    'allDay' => true,
                    'url' => Url::toRoute(['torneo/view', 'id' => $torneo->id]),
                ];
            }

        }

        //La libreria FullCalendar requiere que los eventos esten en formato json
        $eventos = json_encode($eventos);

        return $this->render('calendario', [
            'eventos' => $eventos,
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

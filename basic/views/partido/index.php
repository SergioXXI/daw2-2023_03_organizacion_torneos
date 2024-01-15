<?php

use app\models\Partido;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\PartidoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Partidos');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="partido-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Partido'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'id',
        'jornada',
        'fecha',
        'torneo_id',
        [
            'attribute' => 'reserva_id',
            'format' => 'raw',
            'value' => function ($model) {
                if ($model->reserva_id === null) {
                    return Html::a(
                        'Reservar Pista', // Texto del botón
                        ['generar_reserva', 'id' => $model->id],
                        ['class' => 'btn btn-success']

                    );
                } else {
                    return $model->reserva_id; // O el valor real de reserva_id si no es nulo
                }
            },
        ],
        [
            'class' => ActionColumn::className(),
            'urlCreator' => function ($action, Partido $model, $key, $index, $column) {
                return Url::toRoute([$action, 'id' => $model->id]);
             }
        ],
    ],
]); ?>




</div>

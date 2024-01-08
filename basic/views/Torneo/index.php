<?php

use app\models\Torneo;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\TorneoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Torneos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="torneo-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Torneo', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'nombre',
            'descripcion',
            'participantes_max',
            [
                'attribute' => 'disciplina_id',
                'value' => 'disciplina.nombre', 
            ],
            [
                'attribute' => 'tipo_torneo_id',....
                'value' => 'tipo_torneo.nombre', 
            ],
            [
                'attribute' => 'clase_id',
                'value' => 'clase.titulo', 
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Torneo $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>

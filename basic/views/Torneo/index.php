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

    

    <?php  //echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php
    if (Yii::$app->user->can('admin')) 
    {
        GridView::widget([
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
                    'attribute' => 'tipo_torneo_id',
                    'value' => 'tipo_torneo.nombre', 
                ],
                [
                    'attribute' => 'clase_id',
                    'value' => 'clase.titulo', 
                ],
                'fecha_inicio',
                'fecha_limite',
                [
                    'class' => ActionColumn::className(),
                    'urlCreator' => function ($action, Torneo $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'id' => $model->id]);
                     }
                ],
            ],
        ]);
    }else{
        echo GridView::widget([
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
                    'attribute' => 'tipo_torneo_id',
                    'value' => 'tipoTorneo.nombre', 
                ],
                [
                    'attribute' => 'clase_id',
                    'value' => 'clase.titulo', 
                ],
                'fecha_inicio',
                'fecha_limite',
                [
                    'class' => ActionColumn::className(),'template'=>'{view}',      
                    'urlCreator' => function ($action, Torneo $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'id' => $model->id]);
                     }
                ],
            ],
        ]); 
    }
        ?>

</div>

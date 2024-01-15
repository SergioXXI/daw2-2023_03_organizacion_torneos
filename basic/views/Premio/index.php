<?php

use app\models\Premio;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\PremioSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Premios');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="premio-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php
        if ((Yii::$app->user->can('admin'))||(Yii::$app->user->can('organizador'))||(Yii::$app->user->can('sysadmin'))) 
        {
            echo'<p>'.
                Html::a(Yii::t('app', 'Create Premio'), ['create'], ['class' => 'btn btn-success'])
            .'</p>';

            // echo $this->render('_search', ['model' => $searchModel]);

            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'id',
                    'nombre',
                    'descripcion',
                    [
                        'attribute' => 'Categoria',
                        'value' => 'categoria.nombre', 
                    ],
                    [
                        'attribute' => 'Torneo',
                        'value' => 'torneo.nombre', 
                    ],
                    [
                        'attribute' => 'equipo_id',
                        'format' => 'raw',
                        'value' => function ($model) {
                            if ($model->equipo_id === null) {
                                return Html::a(
                                    'Asignar ganador', // Texto del botón
                                    ['asignar_ganador', 'id' => $model->id],
                                    ['class' => 'btn btn-success']
                                );
                            } else {
                                return $model->equipo_id; // O el valor real de reserva_id si no es nulo
                            }
                        },
                    ],
                    //'equipo_id',
                    [
                        'class' => ActionColumn::className(),
                        'urlCreator' => function ($action, Premio $model, $key, $index, $column) {
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
                    'categoria_id',
                    'torneo_id',
                    //'equipo_id',
                    [
                        'class' => ActionColumn::className(),'template'=>'{view}', 
                        'urlCreator' => function ($action, Premio $model, $key, $index, $column) {
                            return Url::toRoute([$action, 'id' => $model->id]);
                        }
                    ],
                ],
            ]); 
        }
    ?>


</div>

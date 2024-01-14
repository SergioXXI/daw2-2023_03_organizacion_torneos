<?php

use app\models\Clase;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\ClaseSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Clases';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clase-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php
        if ((Yii::$app->user->can('admin'))||(Yii::$app->user->can('organizador'))||(Yii::$app->user->can('sysadmin')||(Yii::$app->user->can('gestor'))))
        {
            echo'<p>'.
                Html::a('Create Clase', ['create'], ['class' => 'btn btn-success'])
            .'</p>';

            // echo $this->render('_search', ['model' => $searchModel]);

            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'id',
                    'titulo',
                    'descripcion',
                    'imagen_id',
                    [
                        'class' => ActionColumn::className(),
                        'urlCreator' => function ($action, Clase $model, $key, $index, $column) {
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
                    'titulo',
                    'descripcion',
                    'imagen_id',
                    [
                        'class' => ActionColumn::className(),'template'=>'{view}',
                        'urlCreator' => function ($action, Clase $model, $key, $index, $column) {
                            return Url::toRoute([$action, 'id' => $model->id]);
                        }
                    ],
                ],
            ]); 
        }
    ?>


</div>

<?php

use app\models\TipoTorneo;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\TipoTorneoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Tipo Torneos');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipo-torneo-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php
        if ((Yii::$app->user->can('admin'))||(Yii::$app->user->can('organizador'))||(Yii::$app->user->can('sysadmin'))) 
            {
            echo'<p>'.
                Html::a(Yii::t('app', 'Create Tipo Torneo'), ['create'], ['class' => 'btn btn-success'])
            .'</p>';

             // echo $this->render('_search', ['model' => $searchModel]);

            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'id',
                    'nombre',
                    [
                        'class' => ActionColumn::className(),
                        'urlCreator' => function ($action, TipoTorneo $model, $key, $index, $column) {
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
                    [
                        'class' => ActionColumn::className(),'template'=>'{view}',
                        'urlCreator' => function ($action, TipoTorneo $model, $key, $index, $column) {
                            return Url::toRoute([$action, 'id' => $model->id]);
                        }
                    ],
                ],
            ]); 
        }
    ?>


</div>

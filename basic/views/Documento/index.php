<?php

use app\models\Documento;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\DocumentoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Documentos');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="documento-index">

    <h1><?= Html::encode($this->title) ?></h1>

    
    <?php
        
        if ((Yii::$app->user->can('admin'))||(Yii::$app->user->can('organizador'))||(Yii::$app->user->can('sysadmin'))) 
        {
            // echo $this->render('_search', ['model' => $searchModel]);
            echo'<p>'.
                Html::a(Yii::t('app', 'Create Documento'), ['create'], ['class' => 'btn btn-success'])
            .'</p>';
            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'id',
                    'ruta',
                    [
                        'class' => ActionColumn::className(),
                        'urlCreator' => function ($action, Documento $model, $key, $index, $column) {
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
                    'ruta',
                    [
                        'class' => ActionColumn::className(),'template'=>'{view}',
                        'urlCreator' => function ($action, Documento $model, $key, $index, $column) {
                            return Url::toRoute([$action, 'id' => $model->id]);
                        }
                    ],
                ],
            ]);
        }
    ?>


</div>

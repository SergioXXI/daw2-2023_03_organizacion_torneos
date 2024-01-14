<?php

use app\models\Normativa;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\NormativaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Normativas');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="normativa-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php
    if ((Yii::$app->user->can('admin'))||(Yii::$app->user->can('organizador'))||(Yii::$app->user->can('sysadmin'))) 
    {
        echo'<p>'.
            Html::a(Yii::t('app', 'Create Normativa'), ['create'], ['class' => 'btn btn-success'])
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
                'documento_id',
                [
                    'class' => ActionColumn::className(),
                    'urlCreator' => function ($action, Normativa $model, $key, $index, $column) {
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
                'documento_id',
                [
                    'class' => ActionColumn::className(),'template'=>'{view}',
                    'urlCreator' => function ($action, Normativa $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'id' => $model->id]);
                    }
                ],
            ],
        ]); 
    }
    ?>


</div>

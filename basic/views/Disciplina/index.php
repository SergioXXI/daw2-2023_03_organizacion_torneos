<?php

use app\models\Disciplina;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\DisciplinaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Disciplinas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="disciplina-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php
    if ((Yii::$app->user->can('admin'))||(Yii::$app->user->can('organizador'))||(Yii::$app->user->can('sysadmin')||(Yii::$app->user->can('gestor')))) 
    {
        echo'<p>'.
            Html::a('Create Disciplina', ['create'], ['class' => 'btn btn-success'])
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
                    'class' => ActionColumn::className(),
                    'urlCreator' => function ($action, Disciplina $model, $key, $index, $column) {
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
                [
                    'class' => ActionColumn::className(),'template'=>'{view}',
                    'urlCreator' => function ($action, Disciplina $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'id' => $model->id]);
                    }
                ],
            ],
        ]);
    }
    ?>

</div>

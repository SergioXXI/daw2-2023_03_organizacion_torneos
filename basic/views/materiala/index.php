<?php

use app\models\Material;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\MaterialSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Materials');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="material-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php
        if ((Yii::$app->user->can('admin'))||(Yii::$app->user->can('sysadmin')))
        {
            echo'<p>'.
                Html::a(Yii::t('app', 'Create Material'), ['create'], ['class' => 'btn btn-success'])
            .'</p>';

            // echo $this->render('_search', ['model' => $searchModel]);

            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'id',
                    'nombre',
                    'color',
                    'descripcion',
                    [
                        'class' => ActionColumn::className(),
                        'urlCreator' => function ($action, Material $model, $key, $index, $column) {
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
                    'color',
                    'descripcion',
                    [
                        'class' => ActionColumn::className(),'template'=>'{view}',
                        'urlCreator' => function ($action, Material $model, $key, $index, $column) {
                            return Url::toRoute([$action, 'id' => $model->id]);
                        }
                    ],
                ],
            ]); 
        }
    ?>


</div>

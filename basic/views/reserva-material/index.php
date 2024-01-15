<?php

use app\models\ReservaMaterial;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\ReservaMaterialSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Reserva Materials');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reserva-material-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Reserva Material'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'reserva_id',
            'material_id',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, ReservaMaterial $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'reserva_id' => $model->reserva_id, 'material_id' => $model->material_id]);
                 }
            ],
        ],
    ]); ?>


</div>

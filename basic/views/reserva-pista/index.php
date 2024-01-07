<?php

use app\models\ReservaPista;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\ReservaPistaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Reserva Pistas');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reserva-pista-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Reserva Pista'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'reserva_id',
            'pista_id',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, ReservaPista $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'reserva_id' => $model->reserva_id, 'pista_id' => $model->pista_id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>

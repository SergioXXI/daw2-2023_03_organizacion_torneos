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

?>
<div class="reserva-pista-index">

    <h1 class='mb-4'><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Crear Reserva pista'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => 'Mostrando ' . Html::tag('b', '{begin}-{end}') . ' de ' .  Html::tag('b', '{totalCount}') . ' elementos', //Para cambiar el idioma del texto del summary
        'emptyText' => 'No hay resultados',
        'pager' => [ 'class' => yii\bootstrap5\LinkPager::class ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //Genera un enlace para poder ver la reserva asociada a la id mostrada
            [
                'format' => 'raw',
                'attribute' => 'reserva_id',
                'value' => function ($model) {
                    $url = Url::toRoute(['reserva/view', 'id' => $model->reserva_id]);
                    return Html::a($model->reserva_id, $url);
                },

            ],

            'reservaFecha',

            //Genera un enlace para poder ver la reserva asociada a la id mostrada
            [
                'format' => 'raw',
                'attribute' => 'pista_id',
                'value' => function ($model) {
                    $url = Url::toRoute(['pista/view', 'id' => $model->pista_id]);
                    return Html::a($model->pista_id, $url);
                },

            ],

            'pistaNombre',

            [
                'class' => ActionColumn::className(),
                'template' => '{view} {delete}', //Eliminar la opción de editar
                'urlCreator' => function ($action, ReservaPista $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'reserva_id' => $model->reserva_id, 'pista_id' => $model->pista_id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\grid\GridView;



/** @var yii\web\View $this */
/** @var app\models\Reserva $model */
/** @var app\models\Material $material */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Reservas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="reserva-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Añadir material a la reserva', ['material/materiales_reservas', 'id_reserva'=> $model->id], ['class' => 'btn btn-success']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'fecha',
            'usuario_id',
        ],
    ]) ?>
    <h2 class="mt-5 mb-4">Materiales reservados</h2>
    <?= GridView::widget([
        'dataProvider' => $materialProvider,
        'summary' => 'Mostrando ' . Html::tag('b', '{begin}-{end}') . ' de ' .  Html::tag('b', '{totalCount}') . ' elementos', //Para cambiar el idioma del texto del summary
        'emptyText' => 'No hay resultados',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //Genera un enlace para poder ver la pista asociada a esta id
            [
                'format' => 'raw',
                'attribute' => 'Nombre',
                'value' => function ($model) {
                    $url = Url::toRoute(['material/view', 'id' => $model->id]);
                    return Html::a($model->nombre, $url);
                },

            ],
        ],
    ]); ?>



</div>

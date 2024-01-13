<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\Direccion $model */

$this->title = 'Dirección (' . $model->id . ')';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Direcciones'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="direccion-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="d-flex justify-content-between mb-3">
        <div>
            <?= Html::a(Yii::t('app', 'Editar'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('app', 'Eliminar'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
        </div>
        <?= Html::a(Html::tag('i', '', ['class' => 'fa-solid fa-location-dot']) . ' Consultar en el mapa ', 'https://maps.google.com/maps?q=' . Html::encode($model->direccionCompleta) . '', ['class' => 'btn btn-outline-dark', 'title' => 'Consultar en el mapa', 'target' => '_blank']) ?>
    </div>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'calle',
            'numero',
            'cod_postal',
            'ciudad',
            'provincia',
            'pais',
        ],
    ]) ?>

    <h2 class="mt-5 mb-4">Pistas que usan esta dirección</h2>

    <?= GridView::widget([
        'dataProvider' => $pistasProvider,
        'summary' => 'Mostrando ' . Html::tag('b', '{begin}-{end}') . ' de ' .  Html::tag('b', '{totalCount}') . ' elementos', //Para cambiar el idioma del texto del summary
        'emptyText' => 'No hay resultados',
        'pager' => [ 'class' => yii\bootstrap5\LinkPager::class ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            //Genera un enlace para poder ver la pista asociada a esta id
            [
                'format' => 'raw',
                'attribute' => 'id',
                'value' => function ($model) {
                    $url = Url::toRoute(['pista/view', 'id' => $model->id]);
                    return Html::a($model->id, $url);
                },

            ],

            'nombre',
        ],
    ]); ?>


</div>

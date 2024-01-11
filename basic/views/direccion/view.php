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

    <p>
        <?= Html::a(Yii::t('app', 'Editar'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Eliminar'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

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

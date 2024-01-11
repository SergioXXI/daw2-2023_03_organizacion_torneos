<?php

use app\models\Direccion;
use app\models\Disciplina;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\Pista $model */

$this->title = Html::encode($model->nombre) . ' (' . $model->id . ')';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pistas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="pista-view">

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
            'nombre',
            'descripcion',

            [
                'format' => 'raw',
                'label' => 'Dirección ID',
                'value' => function ($model) {
                    $url = Url::toRoute(['direccion/view', 'id' => $model->direccion_id]);
                    return Html::a($model->direccion_id, $url);
                },

            ],

            [
                'label' => 'Dirección',
                'value' => Direccion::find()->where(['id' => $model->direccion_id])->one()->direccionCompleta,
            ],

            [
                'format' => 'raw',
                'label' => 'Disciplina ID',
                'value' => function ($model) {
                    $url = Url::toRoute(['disciplina/view', 'id' => $model->disciplina_id]);
                    return Html::a($model->disciplina_id, $url);
                },

            ],

            [
                'label' => 'Disciplina',
                'value' => Disciplina::find()->where(['id' => $model->disciplina_id])->one()->nombre,
            ]
        ],
    ]) ?>

    <h2 class="mt-5 mb-4">Reservas asociadas</h2>

    <?= GridView::widget([
        'dataProvider' => $reservasProvider,
        'summary' => 'Mostrando ' . Html::tag('b', '{begin}-{end}') . ' de ' .  Html::tag('b', '{totalCount}') . ' elementos', //Para cambiar el idioma del texto del summary
        'emptyText' => 'No hay resultados',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            //Genera un enlace para poder ver la pista asociada a esta id
            [
                'format' => 'raw',
                'attribute' => 'id',
                'value' => function ($model) {
                    $url = Url::toRoute(['reserva/view', 'id' => $model->id]);
                    return Html::a($model->id, $url);
                },

            ],

            'fecha',
        ],
    ]); ?>

</div>

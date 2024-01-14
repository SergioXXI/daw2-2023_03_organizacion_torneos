<?php

use app\models\Direccion;
use app\models\Disciplina;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\ReservaPista $model */

$this->title = 'Reserva "' . Html::encode($model->PistaNombre) . '" (' . $model->Reservafecha . ')';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Reserva pista'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="reserva-pista-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Eliminar'), ['delete', 'reserva_id' => $model->reserva_id, 'pista_id' => $model->pista_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', '¿Estás seguro de que deseas eliminar este elementos?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'reserva_id',
            'pista_id',
        ],
    ]) ?>

    <h2 class="mt-5 mb-4">Datos de la reserva</h2>

    <?= DetailView::widget([
        'model' => $reserva,
        'attributes' => [
            'id',
            'fecha',

            [
                'format' => 'raw',
                'label' => 'Usuario ID',
                'value' => function ($model) {
                    $url = Url::toRoute(['usuario/view', 'id' => $model->usuario_id]);
                    return Html::a($model->usuario_id, $url);
                },

            ],
        ],
    ]) ?>

    <h2 class="mt-5 mb-4">Datos de la pista</h2>

    <?= DetailView::widget([
        'model' => $pista,
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
                'value' => Direccion::find()->where(['id' => $pista->direccion_id])->one()->direccionCompleta,
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
                'value' => Disciplina::find()->where(['id' => $pista->disciplina_id])->one()->nombre,
            ]
        ],
    ]) ?>

</div>

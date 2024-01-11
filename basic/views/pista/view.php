<?php

use app\models\Direccion;
use app\models\Disciplina;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

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
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
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

</div>

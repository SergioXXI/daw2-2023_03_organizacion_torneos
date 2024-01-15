<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ReservaMaterial $model */

$this->title = Yii::t('app', 'Update Reserva Material: {name}', [
    'name' => $model->reserva_id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Reserva Materials'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->reserva_id, 'url' => ['view', 'reserva_id' => $model->reserva_id, 'material_id' => $model->material_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="reserva-material-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

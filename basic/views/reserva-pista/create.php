<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ReservaPista $model */

$this->title = Yii::t('app', 'Crear Reserva Pista');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Reserva Pistas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reserva-pista-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

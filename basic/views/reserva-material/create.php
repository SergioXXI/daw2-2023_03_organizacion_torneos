<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ReservaMaterial $model */

$this->title = Yii::t('app', 'Create Reserva Material');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Reserva Materials'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reserva-material-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

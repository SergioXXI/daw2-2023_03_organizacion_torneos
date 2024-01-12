<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Reserva $model */

$this->title = 'Añadir materiales';
$this->params['breadcrumbs'][] = ['label' => 'Reservas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reserva-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('materiales_reservas', [
        'model' => $model,
    ]) ?>

</div>

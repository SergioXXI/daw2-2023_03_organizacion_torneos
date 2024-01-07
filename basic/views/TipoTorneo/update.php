<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TipoTorneo $model */

$this->title = 'Update Tipo Torneo: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tipo Torneos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tipo-torneo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

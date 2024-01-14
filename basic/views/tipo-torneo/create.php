<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TipoTorneo $model */

$this->title = Yii::t('app', 'Create Tipo Torneo');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tipo Torneos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipo-torneo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

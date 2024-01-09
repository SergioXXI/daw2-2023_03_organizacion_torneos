<?php

use app\models\Direccion;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Pista $model */

$this->title = Yii::t('app', 'Update Pista: {name}', [
    'name' => $model->id,
]);

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pistas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id . ' / ' . $model->nombre, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="pista-update">

    <h1><?= Html::encode($this->title) ?></h1>

    
    <?php //print_r($model); ?>
    
    <?= $this->render('_form', [
        'model' => $model,
        'model_direccion' => $model_direccion,
    ]) ?>

</div>

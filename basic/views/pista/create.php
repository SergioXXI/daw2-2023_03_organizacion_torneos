<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Pista $model */

$this->title = Yii::t('app', 'Crear Pista');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pistas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="pista-create">

    <h1><?= Html::encode($this->title) ?></h1>
   
    <?= $this->render('_form', [
        'model' => $model,
        'model_direccion' => $model_direccion,
    ]) ?>

</div>

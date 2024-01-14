<?php

use app\models\Direccion;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Pista $model */

$this->title = Yii::t('app', 'Editar {name} ({id})', [
    'id' => $model->id,
    'name' => Html::encode($model->nombre),
]);

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pistas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pista-update">

    <h1><?= Html::encode($this->title) ?></h1>

    
    <?php //print_r($model); ?>
    
    <?= $this->render('_form', [
        'model' => $model,
        'model_direccion' => $model_direccion,
    ]) ?>

</div>

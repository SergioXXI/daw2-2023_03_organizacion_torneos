<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Direccion $model */

$this->title = Yii::t('app', 'Editar Dirección ({id})', [
    'id' => $model->id,
    'name' => Html::encode($model->direccionCompleta),
]);

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Direcciones'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="direccion-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

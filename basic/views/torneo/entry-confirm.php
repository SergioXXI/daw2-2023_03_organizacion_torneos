<?php
use yii\helpers\Html;
?>
<p>You have entered the following information:</p>

<ul>
    <li><label>Nombre</label>: <?= Html::encode($model->nombre) ?></li>
    <li><label>Descripcion</label>: <?= Html::encode($model->descripcion) ?></li>
    <li><label>participantes_max</label>: <?= Html::encode($model->participantes_max) ?></li>
    <li><label>disciplina_id</label>: <?= Html::encode($model->disciplina_id) ?></li>
    <li><label>tipo_torneo_id</label>: <?= Html::encode($model->tipo_torneo_id) ?></li>
    <li><label>clase_id</label>: <?= Html::encode($model->clase_id) ?></li>
</ul>
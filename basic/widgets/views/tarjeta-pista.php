<?php 
use yii\helpers\Html; 
use app\models\Pista;


//comprobar que las variable han llegado
if(!isset($model)) $model = new Pista();
 ?>

<div class="col d-flex align-items-stretch">
  <div class="card h-100 w-100">
    <div class="card-body d-flex flex-column">
      <h5 class="card-title text-truncate"><?= Html::encode($model->nombre) ?></h5>
      <p class="card-text mb-1 text-secondary fw-bold"><?= Html::encode($model->disciplinaNombre) ?> </p>
      <hr class="my-1">
      <p class="card-text my-1 text-truncate"><b>Descripción: </b><?= Html::encode($model->descripcion) ?> </p>
      <p class="card-text mt-2 mb-3 text-truncate"><b>Ubicación: </b><?= Html::encode($model->direccionCompleta) ?> </p>
      <?= Html::a('Consultar información', ['ver-pista', 'id' => $model->id], ['class' => 'btn btn-primary mt-auto']) ?>
    </div>
  </div>
</div>
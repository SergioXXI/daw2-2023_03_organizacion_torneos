<?php 
use yii\helpers\Html; 
use app\models\Pista;


//comprobar que las variable han llegado
if(!isset($model)) $model = new Pista();
 ?>

<div class="col-md-6 mb-4">
<div class="card">
    <div class="card-body">
      <h5 class="card-title"> <?= Html::encode($model->nombre) ?></h5>
      <p class="card-text mb-2 text-secondary fw-bold"> <?= Html::encode($model->disciplinaNombre) ?> </p>
      <p class="card-text my-2"> <?= Html::encode($model->descripcion) ?> </p>
      <p class="card-text my-2"> <?= Html::encode($model->direccionCompleta) ?> </p>
      <?= Html::a('Consultar información', ['ver-pista', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </div>
</div>
</div>
<?php use yii\helpers\Html; ?> 

<?php //print_r($model->attributes); ?>

<div class="col-md-4 mb-4">
<div class="card">
    <div class="card-body">
      <h5 class="card-title"> <?= Html::encode($model->nombre) ?></h5>
      <p class="card-text"> <?= Html::encode($model->descripcion) ?> </p>
      <p class="card-text"> <?= Html::encode($model->direccionCompleta) ?> </p>
    </div>
</div>
</div>
<?php use yii\helpers\Html; ?> 

<?php 
//comprobar que las variable han llegado
if(!isset($datos['id'])) $datos['id'] = '';
if(!isset($datos['titulo'])) $datos['titulo'] = '';
if(!isset($datos['fecha'])) $datos['fecha'] = '';
 ?>

<div class="d-flex justify-content-between p-3" id="<?= Html::encode($datos['id']) ?>">
	<div>
		<p class="h4"><?= Html::encode($datos['titulo']) ?></p>
		<p class="text-secondary mb-0 h6"><?= Html::encode($datos['fecha']) ?></p>
	</div>
  <?php if ($botonInfo) { ?>
	  <div class="col-auto mx-1 px-0 d-flex align-items-center"><?= Html::a('Más información', ['partido/view', 'id' => $datos['id']], ['class' => 'btn btn-outline-secondary fw-bold shadow-sm',]) ?></div>
  <?php }; ?>
</div>
<?php use app\controllers\CalendarioController;
      use yii\helpers\Html; ?> 

<?php 
//comprobar que las variable han llegado
if(!isset($datos['id'])) $datos['id'] = '';
if(!isset($datos['titulo'])) $datos['titulo'] = '';
if(!isset($datos['disciplina'])) $datos['disciplina'] = '';
if(!isset($datos['clase'])) $datos['clase'] = '';
if(!isset($datos['fecha'])) $datos['fecha'] = '';
if(!isset($datos['tipo'])) $datos['tipo'] = '';
if(!isset($datos['id'])) $datos['id'] = '';
if(!isset($datos['jornada'])) $datos['jornada'] = '';
 ?>

<div class="d-flex justify-content-between px-3 py-2 <?= $resaltar ? 'bg-light bg-gradient rounded' : ''; ?>" id="<?= Html::encode($datos['fecha']) ?>">
	<div>
		<p class="h4"><?= Html::encode($datos['titulo']) ?></p>
		<div class="d-flex align-items-center mb-0 gap-3">
			<p class="text-secondary h6 mb-0"><?= Html::encode($datos['fecha']) ?></p>
			<p class="text-secondary h6 mb-0"><?= Html::encode($datos['disciplina']) ?></p>
			<p class="text-secondary h6 mb-0"><?= Html::encode($datos['clase']) ?></p>
		</div>
		<p class="h5 mt-2 mb-0"><?= $datos['tipo'] == 'partido' ? 
		Html::encode(CalendarioController::getTextoEvento($datos['tipo'],$datos['jornada'])) : 
		Html::encode(CalendarioController::getTextoEvento($datos['tipo'])) ?></p>
	</div>
  <?php if ($botonInfo) { ?>
	  <div class="col-auto mx-1 px-0 d-flex align-items-center"><?= Html::a('Más información', [$datos['tipo'] == 'partido' ? 'partido/view' : 'torneo/view', 'id' => $datos['id']], ['class' => 'btn btn-outline-secondary fw-bold shadow-sm',]) ?></div>
  <?php }; ?>
</div>
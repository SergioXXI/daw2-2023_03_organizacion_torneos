<?php use yii\helpers\Html; ?> 

<?php //print_r($model->attributes); ?>

<div class="d-flex justify-content-between p-3 <?= $resaltar ? 'bg-light bg-gradient rounded' : ''; ?>" id="<?= Html::encode($fecha) ?>">
	<div>
		<p class="h4"><?= Html::encode($titulo) ?></p>
		<p class="text-secondary mb-0 h6"><?= Html::encode($fecha) ?></p>
	</div>
  <?php if ($botonInfo) { ?>
	  <div class="col-auto mx-1 px-0 d-flex align-items-center"><?= Html::a('Más información', ['partido'], ['class' => 'btn btn-outline-secondary fw-bold shadow-sm',]) ?></div>
  <?php }; ?>
</div>
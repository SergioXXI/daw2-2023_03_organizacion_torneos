<?php 

use yii\helpers\Html; 
use app\models\Partido;



if(empty($partido)) $partido = new Partido();

?> 


<div class="col d-flex align-items-stretch">
	<div class="card h-100 w-100 shadow">
		<div class="card-body d-flex flex-column">
			<h5 class="card-title text-truncate text-center">Jornada <?= Html::encode($partido->jornada) ?></h5>
			<p class="text-secondary h6 mb-1 text-center"><?= Html::encode(date('Y-m-d',strtotime($partido->fecha))) ?></p>
			<hr class="my-1">
			<div class="mb-3">
				<?php 
					foreach($partidoEquipos as $partidoEquipo) { 
						$equipo = $partidoEquipo->equipo; ?>
						<div class="d-flex justify-content-between px-3 align-items-center">
							<p class="col-9 card-text my-1 text-truncate fs-5">-<?= Html::encode($equipo->nombre); ?></p>
							<p class="col-1 card-text my-1 text-truncate fs-5"><?= Html::encode($partidoEquipo->puntos === null ? '-' : $partidoEquipo->puntos ); ?></p>
						</div>
				<?php }; ?>
			</div>
			<?= Html::a('Consultar información', ['partido/view', 'id' => $partido->id], ['class' => 'btn btn-primary mt-auto']) ?>
		</div>
	</div>
</div>



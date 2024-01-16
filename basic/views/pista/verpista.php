<?php

use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use app\widgets\EventoTarjetaWidget;
use yii\bootstrap5\LinkPager;


$this->registerJsFile('https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js', ['position' => View::POS_HEAD]);
$this->registerCssFile(Yii::getAlias('@web/css/calendar.css'));

$consulta_direccion = 'https://maps.google.com/maps?q=' . urlencode(Html::encode($model->direccionCompleta)) . '';

$consulta_embed = $consulta_direccion . ';&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed';

?>

<h1 class="mb-2 h1 mt-0">Información sobre la pista</h2>

<hr>

<div class="row d-flex justify-content-between px-2 gap-4">
	<div class="col-7" id="izq">
		<div class="">
			<h1> <?= $model->nombre ?> </h1>
			<p class="mt-3 d-block fs-5 text-truncate"><b>Disciplina:</b> <?= $model->disciplinaNombre ?></p>
			<p class="fs-5 d-block text-truncate-long"><b>Descripción:</b> <?= $model->descripcion ?></p>
			<p class="mt-3 d-block fs-5 text-truncate-long"><b>Dirección: </b><?= $model->direccionCompleta ?></p>
		</div>
	</div>
	<div class="col-auto d-flex flex-column" id="der">
		<iframe src="<?= $consulta_embed; ?>" frameborder="0" scrolling="no" style="width: 400px; height: 300px; border: 1px solid black;"></iframe>
		<?= Html::a(Html::tag('i', '', ['class' => 'fa-solid fa-location-dot']) . ' Consultar en el mapa ', $consulta_direccion, ['class' => 'btn btn-outline-dark mt-4', 'title' => 'Consultar en el mapa', 'target' => '_blank']) ?>
	</div>
</div>



<h2 class="mt-0 mb-2 h2">Calendario de disponibilidad</h2>
<p class="mt-3 mb-1 fs-5">Seleccione un dia libre para realizar una reserva</p>
<hr class="mt-2">


<div id="calendar-pista"></div>

<h2 class="mt-5 mb-2 h2">Proximos eventos</h2>
<hr>

<?php 

//GESTIÓN DE EVENTOS PARA SER MOSTRADOS EN EL APARTADO DE PROXIMOS EVENTOS
$num_reservas = $reservasProvider->getCount();
$i = 0;

foreach ($reservasProvider->getModels() as $reserva) {

	$partido = $reserva->partido;
	//Si la reserva está asociada a un partido
	if(!empty($partido)) {
		$torneo = $partido->torneo; //si existe un partido tiene que estar asociado a un torneo
		//Generar una tarjeta de evento de tipo partido
		echo EventoTarjetaWidget::widget([
			'datos' => [
				'id' => $partido->id,
				'titulo' => (isset($torneo->nombre) ? $torneo->nombre : '') . ' - Jornada ' . $partido->jornada,
				'fecha' => $reserva->fecha,
			],
		]);
	}
	else {
		//Generar una tarjeta de evento de tipo reserva privada
		echo EventoTarjetaWidget::widget([
			'datos' => [
				'titulo' => 'Reserva para uso particular',
				'fecha' => $reserva->fecha,
			],
			'botonInfo' => false,
		]);

	}

	$i++;
	//No imprimir el <hr> en el ultimo elemento
	if($i !== $num_reservas)
		echo '<hr>';
}

//PAGINADOR
echo LinkPager::widget([
    'pagination' => $reservasProvider->pagination,
    'maxButtonCount' => \Yii::$app->params['maxBotonPag'],
    'options' => [
        'class' => yii\bootstrap5\LinkPager::class
    ]
]);

?>

<!-- script de js para poder visualizar el calendario de eventos -->
<script>

	document.addEventListener('DOMContentLoaded', function () {
		var calendarEl = document.getElementById('calendar-pista');

		var calendar = new FullCalendar.Calendar(calendarEl, {
			locale: 'es',
			initialView: 'dayGridMonth',
			events: <?php echo $eventos; ?>,
			showNonCurrentDates: false,
			eventTextColor: 'white',
			firstDay: 1,

			buttonText: {
				today: 'Actual',
			},

			dateClick: function(info) {
				var fecha = info.date; // Convert the clicked date to a string
				var eventos = calendar.getEvents()
				for (var evento of eventos) {
 				   console.log(evento.start.toDateString());
					console.log(fecha.toDateString());
				   if (evento.start.toDateString() === fecha.toDateString()) {
						window.location.href = evento.url; //Esta url ya es filtrada al introducir el evento
						return;
				   }
				}
				
	    		window.location.href = '<?= Url::toRoute(['reserva/create', 'pista_id' => $model->id]); ?>' + '&fecha=' + info.dateStr;
				return;
  			},

		});

		

		calendar.render();
	});


	document.getElementById('my-today-button').addEventListener('click', function () {
		calendar.today();
	});

</script>
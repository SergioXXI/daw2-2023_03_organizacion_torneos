<?php
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use app\widgets\EventoTarjetaWidget;

$this->registerJsFile('https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js', ['position' => View::POS_HEAD]);
$this->registerCssFile("/torneos/basic/web/css/calendar.css");

?>

<h1 class="mb-2 h1 mt-0">Información sobre la pista</h2>

<hr>

<h1> <?= $model->nombre ?> </h1>

<p> <?= $model->direccionCompleta ?></p>

<?= Html::a(Html::tag('i', '', ['class' => 'fa-solid fa-location-dot']) . ' Consultar en el mapa ', 'https://maps.google.com/maps?q=' . Html::encode($model->direccionCompleta) . '', ['class' => 'btn btn-outline-dark', 'title' => 'Consultar en el mapa', 'target' => '_blank']) ?>


<h2 class="mt-5 mb-2 h2">Calendario de disponibilidad</h2>
<hr>


<div id="calendar-pista"></div>

<h2 class="mt-5 mb-2 h2">Proximos eventos</h2>

<hr>

<?php 
$eventos = [];

foreach ($reservas as $reserva) {

	$partido = $reserva->partido;
	//Si la reserva está asociada a un partido
	if(!empty($partido)) {
		$torneo = $partido->torneo; //si existe un partido tiene que estar asociado a un torneo
		$url = Url::toRoute(['pista/ver-pista', 'id' => $model->id, '#' => Html::encode($reserva->fecha)]);
		$titulo = Html::encode($torneo->nombre . ' - J' . $partido->jornada);

		//Generar una tarjeta de evento de tipo partido
		echo EventoTarjetaWidget::widget([
			'id' => $partido->id,
			'titulo' => $torneo->nombre . ' - Jornada ' . $partido->jornada,
			'fecha' => $reserva->fecha,
			'resaltar' => false,
		]);

	}
	else {
		$url = Url::toRoute(['hola']);
		$titulo = 'Reserva privada';

		//Generar una tarjeta de evento de tipo reserva privada
		echo EventoTarjetaWidget::widget([
			'titulo' => 'Reserva para uso particular',
			'fecha' => $reserva->fecha,
			'resaltar' => false,
			'botonInfo' => false,
		]);

	}

	echo '<hr>';
	//Guardar los eventos en un array que será utilizado por el script de FullCalendar
	$eventos[] = [
		'title' => $titulo,
		'start' => $reserva->fecha,
		'color' => 'red',
		'display' => 'background',
		'url' => $url, // Adjust the route as needed
	];

}

$eventos = json_encode($eventos);

?>


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
<?php
use yii\web\View;
use yii\helpers\Html;

$this->registerJsFile('https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js', ['position' => View::POS_HEAD]);
$this->registerCssFile("/torneos/basic/web/css/calendar.css");

$eventos = [];
foreach ($reservas as $reserva) {
	$eventos[] = [
		'title' => 'Reservada',
		'start' => $reserva->fecha,
		'color' => 'red',
		'display' => 'background'
	];

}
$eventos = json_encode($eventos);

?>

<h1> <?= $model->nombre ?> </h1>

<p> <?= $model->direccionCompleta ?></p>

<?= Html::a(Html::tag('i', '', ['class' => 'fa-solid fa-location-dot']) . ' Consultar en el mapa ', 'https://maps.google.com/maps?q=' . $model->direccionCompleta . '', ['class' => 'btn btn-outline-dark', 'title' => 'Consultar en el mapa', 'target' => '_blank']) ?>

<div id="calendar-pista"></div>


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
				var selectedDate = info.date.toString; // Convert the clicked date to a string
	    		window.location.href = window.location.href + '&' + selectedDate;
  			},

		});

		

		calendar.render();
	});


	document.getElementById('my-today-button').addEventListener('click', function () {
		calendar.today();
	});

</script>
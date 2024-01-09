<?php
use yii\web\View;

$this->registerJsFile('https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js', ['position' => View::POS_HEAD]);
$this->registerCssFile("/torneos/basic/web/css/calendar.css");


$events = [];
//foreach ($dataProvider->models as $availability) {
$events[] = [
	'title' => 5 == 5 ? 'Disponible' : 'Reservada',
	'start' => date('2024-01-01'),
	'end' => date('2024-01-01'),
	'color' => 5 == 4 ? 'green' : 'red',
	'display' => 'background'
];
//}
$events = json_encode($events);
?>

<div id="calendar"></div>

<script>

	document.addEventListener('DOMContentLoaded', function () {
		var calendarEl = document.getElementById('calendar');

		var calendar = new FullCalendar.Calendar(calendarEl, {
			locale: 'es',
			initialView: 'dayGridMonth',
			events: <?php echo $events; ?>,
			showNonCurrentDates: false,
			eventTextColor: 'white',
			firstDay: 1,

			header: {
				left:   'title',
  				center: '',
				right:  'Actual prev,next',
			},

			buttonText: {
				today: 'Actual',
			},

		});

		calendar.render();
	});

	document.getElementById("my-today-button").innerHTML="Actual";
	document.getElementById('my-today-button').addEventListener('click', function () {
		calendar.today();
	});

</script>

<?php
use yii\web\View;
use yii\helpers\Html;

$this->registerJsFile('https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js', ['position' => View::POS_HEAD]);
$this->registerJsFile('https://kit.fontawesome.com/6a8d4512ef.js', ['position' => View::POS_HEAD]);
$this->registerCssFile("/torneos/basic/web/css/calendar.css");

$eventos = [];

print_r($torneos);
exit(1);

foreach ($torneos as $torneo) {
	$eventos[] = [
        'title' => 'Inicio',
        'start' => $torneo->fecha_inicio,
        'color' => 'green',
    ];

    if($model->fecha_fin !== null) {
        $eventos[] = [
            'title' => 'Fin',
            'start' => $torneo->fecha,
            'color' => 'red',
        ];
    }

}
$eventos = json_encode($eventos);

?>

<h1>Calendario de eventos</h1>

<div id="calendar"></div>


<script>

	document.addEventListener('DOMContentLoaded', function () {
		var calendarEl = document.getElementById('calendar');

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

		});

		calendar.render();
	});

	document.getElementById("my-today-button").innerHTML="Actual";
	document.getElementById('my-today-button').addEventListener('click', function () {
		calendar.today();
	});

</script>
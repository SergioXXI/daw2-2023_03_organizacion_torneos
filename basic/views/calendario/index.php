
<?php
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;

$this->registerJsFile('https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js', ['position' => View::POS_HEAD]);
$this->registerJsFile('fullcalendar/dist/index.global.js', ['position' => View::POS_HEAD]);

$this->registerJsFile('https://kit.fontawesome.com/6a8d4512ef.js', ['position' => View::POS_HEAD]);

$this->registerCssFile("/torneos/basic/web/css/calendar.css");

$eventos = [];

//print_r($torneos->getModels());

foreach ($torneos->getModels() as $torneo) {
	$eventos[] = [
        'title' => 'Inicio - ' . Html::encode($torneo->nombre),
        'start' => Html::encode($torneo->fecha_inicio),
        'color' => 'green',
		'allDay' => true,
		'url' => Url::toRoute(['torneo/view', 'id' => $torneo->id]),
    ];

    if($torneo->fecha_fin !== null) {
        $eventos[] = [
            'title' => 'Fin - ' . Html::encode($torneo->nombre),
			'start' => Html::encode($torneo->fecha_fin),
			'color' => 'red',
			'allDay' => true,
			'url' => Url::toRoute(['torneo/view', 'id' => $torneo->id]),
        ];
    }

}
$eventos = json_encode($eventos);

?>

<h1>Calendario de eventos</h1>

<div id="calendar-calendario"></div>


<script>

	document.addEventListener('DOMContentLoaded', function () {
		var calendarEl = document.getElementById('calendar-calendario');

		var calendar = new FullCalendar.Calendar(calendarEl, {
			locale: 'es',
			initialView: 'dayGridMonth',
			events: <?php echo $eventos; ?>,
			showNonCurrentDates: false,
			eventTextColor: 'white',
			firstDay: 1,

			dayMaxEventRows: true, // for all non-TimeGrid views
    		moreLinkClick: 'listDay', // Show a popover when the user clicks on "+X more"
			eventLimitText: 'View more events', // Customize the "+ more" text
			

			buttonText: {
				today: 'Actual',
				list: 'Lista',
				dayGridMonth: 'Meses',
			},

			headerToolbar: {
				start: 'dayGridMonth,listMonth', // will normally be on the left. if RTL, will be on the right
  				center: 'title',
  				end: 'today,prev,next' // will normally be on the right. if RTL, will be on the left
			},

			moreLinkContent:function(args){
      			return '+' + args.num + ' más';
    		},

		});

		calendar.render();
	});




</script>

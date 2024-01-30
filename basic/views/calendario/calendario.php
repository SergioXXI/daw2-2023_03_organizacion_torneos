
<?php
use yii\web\View;
use yii\helpers\Html;

$this->registerJsFile('https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js', ['position' => View::POS_HEAD]);
$this->registerJsFile('fullcalendar/dist/index.global.js', ['position' => View::POS_HEAD]);
$this->registerCssFile(Yii::getAlias('@web/css/calendar.css'));

?>

<div class="d-flex justify-content-between align-items-center">
	<div>
		<h1 class="mb-0 h1">Calendario de torneos</h1>
		<div class="d-flex gap-3 align-items-center mt-3">
			<div class="d-flex gap-2 align-items-center">
				<p class="mb-0">Inicio de torneo</p> <i class="fa-solid fa-circle inicio"></i>
			</div>
			<div class="d-flex gap-2 align-items-center">
				<p class="mb-0">Fin de plazo de inscripción</p> <i class="fa-solid fa-circle plazo"></i>
			</div>
			<div class="d-flex gap-2 align-items-center">
				<p class="mb-0">Finalización de torneo</p> <i class="fa-solid fa-circle fin"></i>
			</div>
		</div>
	</div>
	<?= Html::a('Ver Eventos', ['index'], ['class' => 'text-center btn btn-success fw-bold shadow-sm me-2']) ?>
</div>


<hr class="mt-1">
<div id="calendar-calendario"></div>


<script>
	//Script correspondiente a visualizar los eventos generados previamente en formato calendario mediante el uso de FullCalendar
	document.addEventListener('DOMContentLoaded', function () {
		var calendarEl = document.getElementById('calendar-calendario');

		var calendar = new FullCalendar.Calendar(calendarEl, {
			locale: 'es',
			initialView: 'dayGridMonth',
			events: <?php echo $eventos; ?>,
			showNonCurrentDates: false,
			eventTextColor: 'white',
			firstDay: 1,
			dayMaxEventRows: true, //Establecer maximo de eventos por linea
    		moreLinkClick: 'listDay', //Boton +x eventos
		
			//Texto de los botones del header
			buttonText: {
				today: 'Actual',
				list: 'Lista',
				dayGridMonth: 'Meses',
			},

			//Botones del header
			headerToolbar: {
				start: 'dayGridMonth,listMonth', 
  				center: 'title',
  				end: 'today,prev,next'
			},

			//Cambiado el texto del boton ver mas eventos
			moreLinkContent:function(args){
      			return '+' + args.num + ' más';
    		},

		});

		calendar.render();
	});
</script>

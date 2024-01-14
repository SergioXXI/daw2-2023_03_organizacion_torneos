<?php
use app\models\Torneo;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use app\widgets\EventoTarjetaWidget;
use yii\bootstrap5\LinkPager;


$this->registerJsFile('https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js', ['position' => View::POS_HEAD]);
$this->registerCssFile("/torneos/basic/web/css/calendar.css");



$num_eventos = $eventosProvider->getCount();
$num_total_eventos = $eventosProvider->getTotalCount();

?>

<div class="d-flex justify-content-between">
	<h2 class="my-0 h2">Proximos eventos</h2>
	<?= Html::a('Calendario', ['calendario'], ['class' => 'btn btn-success fw-bold shadow-sm me-2',]) ?>
</div>

<hr>

<?= $this->render('_searchbar',  ['model' => $searchModel]); ?>
<div class="">
	<div class="summary">Mostrando <b> <?= Html::encode($num_eventos) ?> </b> de <b> <?= Html::encode($num_total_eventos) ?> </b> elementos.</div>	
	
</div>


<?php 

//GESTIÓN DE EVENTOS PARA SER MOSTRADOS EN EL APARTADO DE PROXIMOS EVENTOS
$i = 0;

foreach ($eventosProvider->getModels() as $evento) {


		//Generar una tarjeta de evento de tipo reserva privada
	if($evento instanceof Torneo) {
		echo EventoTarjetaWidget::widget([
			'titulo' => $evento->nombre,
			'fecha' => date('Y-m-d',strtotime($evento->fecha_inicio)),
			'resaltar' => false,
		]);
	} else {
		$torneo = $evento->torneo;
		echo EventoTarjetaWidget::widget([
			'titulo' => $torneo->nombre . ' - Jornada ' . $evento->jornada,
			'fecha' => date('Y-m-d',strtotime($evento->fecha)),
			'resaltar' => false,
		]);
	}

	$i++;
	//No imprimir el <hr> en el ultimo elemento
	if($i !== $num_eventos)
		echo '<hr>';

	}

	

//PAGINADOR
echo LinkPager::widget([
    'pagination' => $eventosProvider->pagination,
    'maxButtonCount' => \Yii::$app->params['maxBotonPag'],
    'options' => [
        'class' => yii\bootstrap5\LinkPager::class
    ]
]);

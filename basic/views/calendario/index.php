<?php
use app\controllers\CalendarioController;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\widgets\EventoTarjetaWidget;
use yii\bootstrap5\LinkPager;

?>

<?= $this->render('_searchbar',  ['torneoSearch' => $torneoSearch]); ?>


<div class="d-flex justify-content-between">
    <h2 class="mb-0 h2">Proximos eventos</h2>
    <?= Html::a('Ver Calendario', ['calendario'], ['class' => 'text-center btn btn-success fw-bold shadow-sm me-4']) ?>
</div>

<div class="summary mt-2 ms-3">Mostrando <b> <?= Html::encode($eventosProvider->getCount()) ?> </b> de <b> <?= Html::encode($eventosProvider->getTotalCount()) ?> </b> elementos.</div>
<hr class="mt-1">

<?php 

$i=0;
$num_eventos = $eventosProvider->getCount();

//Recorrer el dataProvider de proximos eventos para generar una tarjeta para cada uno de ellos
//Para esto se va a utilizar el widget Evento Tarjeta
foreach($eventosProvider->models as $evento) {
    echo EventoTarjetaWidget::widget([
        'datos' => [
            'titulo' => $evento['nombre'], 
            'fecha' => date('Y-m-d', strtotime($evento['fecha'])),
            'disciplina' => $evento['disciplina'],
            'clase' => $evento['clase'],
            'tipo' => $evento['tipo'],
            'id' => $evento['id'],
            'jornada' => isset($evento['jornada']) ? $evento['jornada'] : '',
        ],
        'resaltar' => false,
        'tarjetaEvento' => 'ampliada',
    ]);

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

?>


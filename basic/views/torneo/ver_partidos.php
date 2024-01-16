<?php

use app\widgets\TarjetaPartidoWidget;
use yii\bootstrap5\LinkPager;
use yii\helpers\Html;


//echo '<pre>';
//print_r(count($partidos));

?> 

<h1 class="mb-1 h1">Jornadas <?=Html::encode($torneo->nombre)?></h1>

<!-- Mostrar elementos visualizados y total -->

<hr class="mb-4">

<div class="summary mt-2 ms-2 mb-2">Se han encontrado <b> <?= Html::encode($partidos->getTotalCount()) ?> </b> elementos.</div>

<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-5 mb-5">

<?php

foreach($partidos->models as $partido) {
    $partidoEquipos = $partido->partidoEquipos;
    $equipos = $partido->equipos;
    //print_r($equipos);
    
    echo TarjetaPartidoWidget::widget([
        'partido' => $partido,
        'partidoEquipos' => $partidoEquipos,
        'equipos' => $equipos,
    ]);
}

?>

</div>


<?php 
echo LinkPager::widget([
    'pagination' => $partidos->pagination,
    'maxButtonCount' => \Yii::$app->params['maxBotonPag'],
    'options' => [
        'class' => yii\bootstrap5\LinkPager::class
    ]
]);
 ?>
<?php

use app\widgets\PistaTarjetaWidget;
use yii\bootstrap5\LinkPager;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Pista $model */
/** @var yii\data\ActiveDataProvider $dataProvider */

?>

<h1 class="mb-1 h1">Listado de pistas</h1>

<hr class="mb-4">

<?= $this->render('_searchbar',  ['model' => $searchModel]); ?>

<!-- Mostrar elementos visualizados y total -->
<div class="summary mt-2 ms-2 mb-2">Se han encontrado <b> <?= Html::encode($models->getTotalCount()) ?> </b> elementos.</div>


<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-5 mb-5">

<?php
// Use the widget
foreach($models->getModels() as $model)
{
    //Se usa el widget PistaTajeta para poder imprimir la información de las pistas
    echo PistaTarjetaWidget::widget([
        'model' => $model,
    ]);
}

?>

</div>

<?php 
echo LinkPager::widget([
    'pagination' => $models->pagination,
    'maxButtonCount' => \Yii::$app->params['maxBotonPag'],
    'options' => [
        'class' => yii\bootstrap5\LinkPager::class
    ]
]);
 ?>
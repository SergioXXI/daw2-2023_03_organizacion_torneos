<?php

use app\widgets\PistaTarjetaWidget;
use yii\bootstrap5\LinkPager;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Pista $model */
/** @var yii\data\ActiveDataProvider $dataProvider */

?>

<?= $this->render('_searchbar',  ['model' => $searchModel]); ?>

<!-- Mostrar elementos visualizados y total -->
<div class="summary">Mostrando <b> <?= Html::encode($models->getCount()) ?> </b> de <b> <?= Html::encode($models->getTotalCount()) ?> </b> elementos.</div>


<div class="row">

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
<?php

use app\models\TorneoSearch;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

//Modelo que se utilizará para buscar torneos por nombre desde el buscador
//de la página inicial redirigiendo a torneos con parametro nombre
$model = new TorneoSearch();
$imagen = Url::to('@web/imagenes/back-inicio.png');

$this->title = 'Torneando';
?>
<div class="site-index">
    <div class="blur px-4 py-5">
        <h1 class="h1 text-center fw-bold text-success">Torneando</h1>
        <p class="fs-4 text-center mt-5">Únete y empieza a jugar en equipos contra otros participantes o simplemente sigue tu torneo favorito a lo largo de sus jornadas</p>
        <!-- Solo permitir ver el botón de unirse a los invitados  -->
        <?php if(Yii::$app->user->isGuest) { ?>
            <div class="text-center mt-4">
                <?= Html::a('Unirse',['site/login'], ['class' => ['btn btn-primary mx-2 px-3 py-1 fs-6 fw-bold']]) ?>
            </div>
        <?php }; ?>

        <!-- Para aportar más contenido a la portada se va a añadir un formulario por get que permita mediante el
            valor introducido redirigir a la vista de torneos con un filtro sobre el nombre del torneo
            Para esto se utiliza un modelo TorneoSearch -->
        <p class="fs-3 text-center mt-5 mb-4 fw-bold">O puedes empezar buscando un torneo</p>
        <?php $form = ActiveForm::begin([
            'action' => ['torneo/index'],
            'method' => 'get',
        ]); ?>

        <div class="input-group w-50 mx-auto mb-3">
            <?= $form->field($model, 'nombre', ['template' => '{input}', 'options' => ['class' => 'form-control rounded-start p-0'], 'inputOptions' => ['class' => 'form-control rounded-start']])->textInput(['placeholder' => 'Busca tu torneo']); ?>
            <?= Html::submitButton('<i class="fas fa-search px-2"></i>', ['class' => 'btn btn-success']) ?> 
        </div>


        <?php ActiveForm::end(); ?>
    </div>
    
</div>

<!-- Cambiar los estilos del body aqui para no afectar al resto de la página al ser establecido el body en la plantilla -->
<style>
    body {
        background: linear-gradient(rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0.7)), url('<?= $imagen ?>') center center fixed no-repeat;
        color: white;
    }
</style>
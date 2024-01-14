<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\Torneo $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Torneos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="torneo-view">

    <h1><?= Html::encode($this->title) ?></h1>

    

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nombre',
            'descripcion',
            'participantes_max',
            'disciplina_id',
            'tipo_torneo_id',
            'clase_id',
            'fecha_inicio',
            'fecha_limite',
        ],
    ]) ?>

    <h2 class="mt-5 mb-4">Equipos Apuntados</h2>
    <?= GridView::widget([
        'dataProvider' => $equipoProvider,
        'summary' => 'Mostrando ' . Html::tag('b', '{begin}-{end}') . ' de ' .  Html::tag('b', '{totalCount}') . ' elementos', //Para cambiar el idioma del texto del summary
        'emptyText' => 'No hay resultados',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //Genera un enlace para poder ver la pista asociada a esta id
            [
                'format' => 'raw',
                'attribute' => 'Nombre',
                'value' => function ($model) {
                    $url = Url::toRoute(['equipo/view', 'id' => $model->id]);
                    return Html::a($model->nombre, $url);
                },

            ],
        ],
    ]); ?>

    <?php
        $imageRoute = $model->getImagens()->select('ruta')->scalar();
        // Check if $imageRoute is not false before displaying the image
        if ($imageRoute !== false && $imageRoute !== null && $imageRoute !== '') {
            echo '<img src="' . $imageRoute . '" alt="Image">';
        } else {
            echo 'No hay imagen para el torneo.';
        }
    ?>
    
        

</div>

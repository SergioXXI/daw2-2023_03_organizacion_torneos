<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\Torneo $model */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Torneos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="torneo-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= Html::a('Unirse al torneo', ['add-torneo', 'model' => $model], ['class' => 'btn btn-success']) ?>
    <?php
    if ((Yii::$app->user->can('admin'))||(Yii::$app->user->can('organizador'))||(Yii::$app->user->can('sysadmin'))) 
    {
         
        echo Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']); 
        echo Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post', 
            ],
        ]);
    }
    ?>
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
    <h2 class="mt-5 mb-4">Premio del torneo</h2>
    <?= GridView::widget([
        'dataProvider' => $premioProvider,
        'summary' => '', //Para cambiar el idioma del texto del summary
        'emptyText' => 'No hay resultados',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //Genera un enlace para poder ver la pista asociada a esta id
            [
                'format' => 'raw',
                'attribute' => 'Nombre',
                'value' => function ($model) {
                    $url = Url::toRoute(['premio/view', 'id' => $model->id]);
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

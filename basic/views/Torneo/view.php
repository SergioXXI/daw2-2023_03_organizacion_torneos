<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

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

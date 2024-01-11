<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Participante $model */

$this->title = $model->usuario->nombre;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Participantes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="participante-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        [
            'label' => 'Nombre del Usuario',
            'value' => $model->usuario->nombre, // Ajusta estos atributos según tu modelo
        ],
        [
            'label' => 'Primer Apellido',
            'value' => $model->usuario->apellido1,
        ],
        [
            'label' => 'Segundo Apellido',
            'value' => $model->usuario->apellido2,
        ],
        'fecha_nacimiento',
        'licencia',
        [
            'label' => 'Tipo Participante',
            'value' => $model->tipoParticipante->nombre, // Ajusta estos atributos según tu modelo
        ],
        'imagen_id',
        
    ],
]) ?>

</div>

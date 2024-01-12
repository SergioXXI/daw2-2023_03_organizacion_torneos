<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\Equipo $model */

$this->title = Yii::t('app', 'Update Equipo: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Equipos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="equipo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'listaCategorias' => $listaCategorias,
    ]) ?>

    <h2>Participantes</h2>
    <?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',
        [
            'attribute' => 'usuario.nombre',
            'label' => 'Nombre del Usuario',
        ],
        [
            'attribute' => 'tipoParticipante.nombre',
            'label' => 'Tipo de Participante',
        ],
        [
            'class' => ActionColumn::className(),
            'template' => '{update}', 
            'urlCreator' => function ($action, $model, $key, $index, $column) {
                return Url::toRoute(["participante/{$action}", 'id' => $model->id]);
            }
            ////////////////////////////////////////////
            //////////  BOTON DE EXPULSAR //////////////
            ////////////////////////////////////////////
        ]
        // Otros atributos que desees mostrar
    ],
]) 

            ////////////////////////////////////////////
            //////////   BOTON DE AÑADIR  //////////////
            ////////////////////////////////////////////

?>
</div>

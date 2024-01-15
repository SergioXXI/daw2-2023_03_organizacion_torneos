<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\helpers\Url;
use yii\widgets\DetailView;


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

    <?php 
    if ((!\Yii::$app->user->can('gestor'))&&(!\Yii::$app->user->can('organizador'))&&(!\Yii::$app->user->can('sysadmin'))&&(\Yii::$app->user->can('usuario')))  
    {
    ?>
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'nombre',
                'descripcion',
                'licencia',
                'categoria.nombre',
                [
                    'value' => $usuario->nombre,
                    'label' => 'Creador',
                ],
            ],
        ]); 
        }else{?>

        <?= $this->render('_form', [
            'model' => $model,
            'listaCategorias' => $listaCategorias,
            'listaParticipantes' => $listaParticipantes, 
        ]) ;
        } 
    ?>
    <h2>Participantes</h2>
    <?= Html::a('Añadir Participante', ['add-participante', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
    <?php if ($tieneParticipantes): ?>
    <?=
    GridView::widget([
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
                'template' => '{update} {expulsar}{lider}',
                'buttons' => [
                    'expulsar' => function ($url, $model, $key) {
                        return Html::a('X', $url, [
                            'title' => Yii::t('app', 'Expulsar'),
                            'data-confirm' => Yii::t('app', '¿Estás seguro de que deseas expulsar a este participante?'),
                            'data-method' => 'post',
                            'class' => 'btn btn-danger',
                        ]);
                    },
                    'lider' => function ($url, $model, $key) use ($equipo) {
                        if ($model->id !== $equipo->creador_id) {
                            return Html::a('L', $url, [
                                'title' => Yii::t('app', 'Lider'),
                                'data-confirm' => Yii::t('app', '¿Estás seguro de que hacer lider a este participante?'),
                                'data-method' => 'post',
                                'class' => 'btn btn-primary',
                            ]);
                        }
                        return '';
                    },
                ],
                'urlCreator' => function ($action, $model, $key, $index, $column) use ($equipo) {
                    if ($action === 'expulsar') {
                        return Url::toRoute(['expulsar-participante', 'equipoId' => $equipo->id, 'participanteId' => $model->id]);
                    } elseif ($action === 'lider') {
                        return Url::toRoute(['lider', 'equipoId' => $equipo->id, 'participante_id' => $model->id]);
                    } else {
                        return Url::toRoute(["participante/{$action}", 'id' => $model->id]);
                    }
                },
            ], // Add a closing curly brace here
        ],
    ]);
?>

        
        
        ?>
        <?php else: ?>
            <p>Este equipo no tiene participantes.</p>
        <?php endif; ?>
</div>

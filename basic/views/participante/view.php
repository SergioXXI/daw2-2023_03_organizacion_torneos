<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;


/** @var yii\web\View $this */
/** @var app\models\Participante $model */
/** @var app\models\Equipo $equipoModel */

$this->title = $model->usuario->nombre;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Participantes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="participante-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
    <?php
 
        if((Yii::$app->user->can('admin') || Yii::$app->user->can('sysadmin') || Yii::$app->user->can('gestor'))) 
        { ?>   
            <?= Html::a(Yii::t('app', 'Actualizar'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('app', 'Borrar'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
        <?php 
        } else if($participanteSesion != null) {
            if($participanteSesion->id == $model->id)
            {?>
                <?= Html::a(Yii::t('app', 'Actualizar'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a(Yii::t('app', 'Borrar'), ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ]) ?>
    <?php    }
        }
    ?>
    </p>
    
    <?php
    // Inicializa la matriz de atributos con los elementos comunes
    $attributes = [
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
    ];

    // Añade atributos adicionales para roles específicos
    if (Yii::$app->user->can('admin') || Yii::$app->user->can('sysadmin') || Yii::$app->user->can('gestor')) {
        array_unshift($attributes, 'id'); // Añade 'id' al principio del array
    }
    ?>

    <?= DetailView::widget([
    'model' => $model,
    'attributes' => $attributes,
    ]) ?>

    <h2>Equipo - Torneo</h2>
    <?php
        if((Yii::$app->user->can('admin') || Yii::$app->user->can('sysadmin') || Yii::$app->user->can('gestor'))) 
        { ?>
            <?= Html::a('Unirse a un equipo', ['add-equipo', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
            <?= Html::a(Yii::t('app', 'Crear Equipo'), ['equipo/create', 'creador_id'=>$model->id], ['class' => 'btn btn-success']) ?>
        <?php 
        } else if($participanteSesion != null) {
            if($participanteSesion->id == $model->id)
            {?>
                <?= Html::a('Unirse a un equipo', ['add-equipo', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
                <?= Html::a(Yii::t('app', 'Crear Equipo'), ['equipo/create', 'creador_id'=>$model->id], ['class' => 'btn btn-success']) ?>
    <?php    }
        }
    
    $columns = [
        'nombre',
        [
            'label' => 'Torneos',
            'value' => function ($model) {
                return implode(', ', ArrayHelper::map($model->torneos, 'id', 'nombre'));
            },
        ],
    ];
    // Añade atributos adicionales para roles específicos
    if (Yii::$app->user->can('admin') || Yii::$app->user->can('sysadmin') || Yii::$app->user->can('gestor')) {
        array_unshift($columns, 'id'); // Añade 'id' al principio del array
    }

    if($participanteSesion != null){  
        $actionColumn = [
            'class' => ActionColumn::className(),
            'template' => '{view} {abandonar}',
            'buttons' => [
                'abandonar' => function ($url, $model, $key) use ($participanteSesion, $participante) {
                    if (Yii::$app->user->can('admin') || Yii::$app->user->can('gestor') || Yii::$app->user->can('sysadmin')) {
                        return Html::a('X', $url, [
                            'title' => Yii::t('app', 'Abandonar'),
                            'data-confirm' => Yii::t('app', '¿Estás seguro de que deseas abandonar el equipo?'),
                            'data-method' => 'post',
                            'class' => 'btn btn-primary',
                        ]);
                    }else if(($participanteSesion->id == $participante->id) && empty($model->torneos)){
                        return Html::a('X', $url, [
                            'title' => Yii::t('app', 'Abandonar'),
                            'data-confirm' => Yii::t('app', '¿Estás seguro de que deseas abandonar el equipo?'),
                            'data-method' => 'post',
                            'class' => 'btn btn-primary',
                        ]);
                    }else{
                        return ''; // No muestra nada si el equipo está en torneos
                    }
                },
            ],
            'urlCreator' => function ($action, $model, $key, $index, $column) use ($participante) {
                if ($action === 'abandonar') {
                    return Url::toRoute(['abandonar-equipo', 'equipoId' => $model->id, 'participanteId' => $participante->id]);
                } else {
                    return Url::toRoute(["equipo/{$action}", 'id' => $model->id]);
                }
            },
        ];
        // Agrega la columna de acción a las columnas
        $columns[] = $actionColumn;

    }
    
    ?>
    <?php if ($tieneEquipo): ?>
        <?= GridView::widget([
        'dataProvider' => $equiposDataProvider,
        'columns' => $columns,
    ]);?>

    <?php else: ?>
        <p>Este participante no tiene equipo.</p>
    <?php endif; ?>
    <?php
    if($participanteSesion != null){  
        if($participanteSesion->id == $model->id){ ?>
            <?= Html::a('Volver', ['user/view-profile'], ['class' => 'btn btn-primary']) ?>
<?php   } 
    }?>
</div>

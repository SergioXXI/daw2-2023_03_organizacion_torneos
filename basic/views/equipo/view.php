<?php
use yii\grid\ActionColumn;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\Equipo $model */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Equipos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="equipo-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p> 
        <?php 
        
            if(Yii::$app->user->can('admin') || Yii::$app->user->can('sysadmin') || Yii::$app->user->can('gestor') )
            {?>
                <?= Html::a(Yii::t('app', 'Actualizar'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);?>
                <?= Html::a(Yii::t('app', 'Borrar'), ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ]);?>
         <?php  }else if($participanteSesion != null) {
                    if($participanteSesion->id == $model->creador_id)
                    {?>
                        <?= Html::a(Yii::t('app', 'Actualizar'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);?>
                        <?= Html::a(Yii::t('app', 'Borrar'), ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                'method' => 'post',
                            ],
                        ]);?>
            <?php    }
                }
        ?>
    </p>
    
    <?php
    // Inicializa la matriz de atributos con los elementos comunes
    $attributes = [
            'nombre',
            'descripcion',
            'licencia',
            'categoria.nombre',
            [
                'value' => $usuario!==null ? $usuario->nombre : "",
                'label' => 'Creador',
            ],
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
    <?php
    $columns = [
        [
            'attribute' => 'usuario.nombre',
            'label' => 'Nombre del Usuario',
        ],
        [
            'attribute' => 'tipoParticipante.nombre',
            'label' => 'Tipo de Participante',
        ],
    ];
    // Añade atributos adicionales para roles específicos
    if (Yii::$app->user->can('admin') || Yii::$app->user->can('sysadmin') || Yii::$app->user->can('gestor')) {
        array_unshift($columns, 'id'); // Añade 'id' al principio del array
    }

    $actionColumn = [
        'class' => ActionColumn::className(),
                'template' => '{view}', // Solo incluye la acción 'view'
                'urlCreator' => function ($action, $model, $key, $index, $column) {
                    return Url::toRoute(["participante/{$action}", 'id' => $model->id]);
                }
    ];

    // Agrega la columna de acción a las columnas
    $columns[] = $actionColumn;
    ?>
    <h2>Participantes</h2>
    <?php if ($tieneParticipantes): ?>
        <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => $columns,
    ]) ?>
    <?php else: ?>
        <p>Este equipo no tiene participantes.</p>
    <?php endif; 
 
        if ((Yii::$app->user->can('admin') || Yii::$app->user->can('gestor') || Yii::$app->user->can('sysadmin'))) 
        {
            ?>
            <?= Html::a('Unir el equipo a un torneo', ['add-torneo', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
        <?php
        }else if($participanteSesion != null) {
            if($participanteSesion->id == $model->creador_id)
            {?>
                <?= Html::a('Unir el equipo a un torneo', ['add-torneo', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
    <?php    }
        }
?>

    <h2>Torneos del equipo</h2>

    <h3>Torneos con incripción abierta</h3>


    <?php
    $columnsT = [
            'nombre', 
            'descripcion',
    ];
    // Añade atributos adicionales para roles específicos
    if (Yii::$app->user->can('admin') || Yii::$app->user->can('sysadmin') || Yii::$app->user->can('gestor')) {
        array_unshift($columnsT, 'id'); // Añade 'id' al principio del array
    }

    $actionColumn = [
        'class' => ActionColumn::className(),
                    'template' => '{salir}',
                    'buttons' => [
                        'salir' => function ($url, $model, $key) {
                            return Html::a('X', $url, [
                                'title' => Yii::t('app', 'Salir'),
                                'data-confirm' => Yii::t('app', '¿Estás seguro de desinscribirte de este torneo?'),
                                'data-method' => 'post',
                                'class' => 'btn btn-primary',
                            ]);
                        },
                    ],
                    'urlCreator' => function ($action, $model, $key, $index, $column) use ($equipo) {
                        return Url::toRoute(['salir-torneo', 'torneoId' => $model['id'],'equipoId' => $equipo->id]);
                    },
    ];

    // Agrega la columna de acción a las columnas
    $columnsTA[] = $actionColumn;
    ?>

    <?php if ($tieneEnInscripcion):?>
    <?= GridView::widget([
        'dataProvider' => new \yii\data\ArrayDataProvider(['allModels' => $torneosEnInscripcion]),
        'columns' => $columnsTA,
    ]) ?>
    <?php else: ?>
        <p>Este equipo no tiene torneos en curso.</p>
    <?php endif; ?>


    <h3>Torneos en Curso</h3>
    <?php if ($tieneTorneosCurso):?>
    <?= GridView::widget([
        'dataProvider' => new \yii\data\ArrayDataProvider(['allModels' => $torneosEnCurso]),
        'columns' =>$columnsT,
    ]) ?>
    <?php else: ?>
        <p>Este equipo no tiene torneos en curso.</p>
    <?php endif; ?>

    
    <h3>Torneos Finalizados</h3>
    <?php if ($tieneTorneosFin): ?>
        <?= GridView::widget([
            'dataProvider' => new \yii\data\ArrayDataProvider(['allModels' => $torneosFinalizados]),
            'columns' => $columnsT,
        ]) ?>
    <?php else: ?>
        <p>Este equipo no tiene torneos finalizados.</p>
    <?php endif; ?>

</div>

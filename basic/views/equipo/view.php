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
        if((Yii::$app->user->can('admin') || Yii::$app->user->can('sysadmin') || Yii::$app->user->can('gestor') || $esDelEquipo))
        {?>
            <?= Html::a(Yii::t('app', 'Actualizar'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);?>
  <?php }
        if((Yii::$app->user->can('admin') || Yii::$app->user->can('sysadmin') || Yii::$app->user->can('gestor')))
        {?>
            <?= Html::a(Yii::t('app', 'Borrar'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]);?>
        <?php }?>
    </p>
    

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nombre',
            'descripcion',
            'licencia',
            'categoria.nombre',
        ],
    ]) ?>

    <h2>Participantes</h2>
    <?php if ($tieneParticipantes): ?>
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
                'template' => '{view}', // Solo incluye la acción 'view'
                'urlCreator' => function ($action, $model, $key, $index, $column) {
                    return Url::toRoute(["participante/{$action}", 'id' => $model->id]);
                }
            ]
        ],
    ]) ?>
    <?php else: ?>
        <p>Este equipo no tiene participantes.</p>
    <?php endif; ?>

    <?= Html::a('Unirse a un torneo', ['add-torneo', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
    
    <h2>Torneos del equipo</h2>

    <h3>Torneos con incripción abierta</h3>
    <?php if ($tieneEnInscripcion):?>
    <?= GridView::widget([
        'dataProvider' => new \yii\data\ArrayDataProvider(['allModels' => $torneosEnInscripcion]),
        'columns' => [
            'id',
            'nombre', 
            'descripcion',
            [
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
            ]
        ],
    ]) ?>
    <?php else: ?>
        <p>Este equipo no tiene torneos en curso.</p>
    <?php endif; ?>


    <h3>Torneos en Curso</h3>
    <?php if ($tieneTorneosCurso):?>
    <?= GridView::widget([
        'dataProvider' => new \yii\data\ArrayDataProvider(['allModels' => $torneosEnCurso]),
        'columns' => [
            'id',
            'nombre', 
            'descripcion',
        ],
    ]) ?>
    <?php else: ?>
        <p>Este equipo no tiene torneos en curso.</p>
    <?php endif; ?>

    
    <h3>Torneos Finalizados</h3>
    <?php if ($tieneTorneosFin): ?>
        <?= GridView::widget([
            'dataProvider' => new \yii\data\ArrayDataProvider(['allModels' => $torneosFinalizados]),
            'columns' => [
                'nombre', 
                'descripcion'
            ],
        ]) ?>
    <?php else: ?>
        <p>Este equipo no tiene torneos finalizados.</p>
    <?php endif; ?>

</div>

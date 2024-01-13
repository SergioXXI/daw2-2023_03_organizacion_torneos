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
        <?= Html::a(Yii::t('app', 'Actualizar'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Borrar'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
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

    <h2>Torneos Activos</h2>
    <?= Html::a('Unirse a un equipo', ['add-torneo', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
   
</div>

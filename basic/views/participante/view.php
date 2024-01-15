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
echo "ID del Modelo: " . $model->id;
$this->title = $model->usuario->nombre;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Participantes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="participante-view">

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

    <h2>Equipo - Torneo</h2>
    <?= Html::a('Unirse a un equipo', ['add-equipo', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
    <?php if ($tieneEquipo): ?>
        <?= GridView::widget([
            'dataProvider' => $equiposDataProvider,
            'columns' => [
                'id',
                'nombre',
                [
                    'label' => 'Torneos',
                    'value' => function ($model) {
                        // Concatenar los nombres de los torneos.
                        return implode(', ', ArrayHelper::map($model->torneos, 'id', 'nombre'));
                    },
                ],
                [
                    'class' => ActionColumn::className(),
                    'template' => '{update} {abandonar}',
                    'buttons' => [
                        'abandonar' => function ($url, $model, $key) {
                            // Verifica si el equipo está inscrito en algún torneo.
                            if ((Yii::$app->user->can('admin') || Yii::$app->user->can('gestor') || Yii::$app->user->can('sysadmin')) || empty($model->torneos)) {
                                return Html::a('X', $url, [
                                    'title' => Yii::t('app', 'Abandonar'),
                                    'data-confirm' => Yii::t('app', '¿Estás seguro de que deseas abandonar el equipo?'),
                                    'data-method' => 'post',
                                    'class' => 'btn btn-primary',
                                ]);
                            }
                            return ''; // No muestra nada si el equipo está en torneos.
                        },
                    ],
                    'urlCreator' => function ($action, $model, $key, $index, $column) use ($participante) {
                        if ($action === 'abandonar') {
                            return Url::toRoute(['abandonar-equipo', 'equipoId' => $model->id, 'participanteId' => $participante->id]);
                        } else {
                            return Url::toRoute(["equipo/{$action}", 'id' => $model->id]);
                        }
                    },
                ]
            ],
        ]) ?>
    <?php else: ?>
        <p>Este participante no tiene equipo.</p>
    <?php endif; ?>
    <?php //echo Html::a('Volver', Yii::$app->request->referrer ?: ['site/index'], ['class' => 'btn btn-primary']);
    ?>
</div>

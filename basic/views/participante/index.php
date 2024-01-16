<?php

use app\models\Participante;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\ParticipanteSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Participantes');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="participante-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Crear Participante'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'nombreUsuario',
                'value' => 'usuario.nombre',
            ],
            [
                'attribute' => 'apellido1Usuario',
                'value' => 'usuario.apellido1',
            ],
            [
                'attribute' => 'apellido2Usuario',
                'value' => 'usuario.apellido2',
            ],
            'fecha_nacimiento',
            'licencia',
            [
                'attribute' => 'nombreTipoParticipante',
                'value' => 'tipoParticipante.nombre',
            ],
            'imagen_id',
            //'usuario_id',
            [
                'class' => ActionColumn::className(),
                'template' => '{view} {update} {delete}', // Añadir 'delete' al template
                'urlCreator' => function ($action, Participante $model, $key, $index, $column) {
                    if ($action === 'delete') {
                        // Ruta personalizada para el botón delete
                        return Url::toRoute(['delete', 'id' => $model->id]);
                    } else {
                        // Rutas estándar para las acciones view y update
                        return Url::toRoute([$action, 'id' => $model->id]);
                    }
                }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>

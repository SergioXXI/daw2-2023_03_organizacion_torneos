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
        <?= Html::a(Yii::t('app', 'Create Participante'), ['create'], ['class' => 'btn btn-success']) ?>
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
                'attribute' => 'usuario.nombre',
                'label' => 'Nombre del Usuario',
            ],
            [
                'attribute' => 'usuario.apellido1',
                'label' => 'Primer Apellido',
            ],
            [
                'attribute' => 'usuario.apellido2',
                'label' => 'Segundo Apellido',
            ],
            'fecha_nacimiento',
            'licencia',
            'tipo_participante_id',
            'imagen_id',
            //'usuario_id',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Participante $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>

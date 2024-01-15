<?php

use app\models\Disciplina;
use app\models\Pista;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\PistaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Pistas');

?>
<div class="pista-index">

    <h1 class='mb-4'><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Crear Pista'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => 'Mostrando ' . Html::tag('b', '{begin}-{end}') . ' de ' .  Html::tag('b', '{totalCount}') . ' elementos', //Para cambiar el idioma del texto del summary
        'emptyText' => 'No hay resultados',
        'pager' => [ 'class' => yii\bootstrap5\LinkPager::class ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'nombre',
            'descripcion',
            
            //Genera un enlace para poder ver la dirección de la pista asociada a la id mostrada
            [
                'format' => 'raw',
                'attribute' => 'direccion_id',
                'value' => function ($model) {
                    $url = Url::toRoute(['direccion/view', 'id' => $model->direccion_id]);
                    return Html::a($model->direccion_id, $url);
                },

            ],
            
            'direccionCompleta',

            //Genera un enlace para poder ver la disciplina de la pista asociada a la id mostrada
            [
                'format' => 'raw',
                'attribute' => 'disciplina_id',
                'value' => function ($model) {
                    $url = Url::toRoute(['disciplina/view', 'id' => $model->disciplina_id]);
                    return Html::a($model->disciplina_id, $url);
                },

            ],

            //Generar un menu drowpdown para poder visualizar las disciplinas disponibles
            [
                'attribute' => 'disciplinaNombre', 'value' => function ($model) {
                    return $model->disciplinaNombre;
                },
                'filter' => Disciplina::getListadoDisciplinasPorNombre(),
                'filterInputOptions' => ['class' => 'form-select']
            ],
            
            //Botones de accion
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Pista $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],

        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>

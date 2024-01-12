<?php

use app\controllers\LogController;
use app\models\Log;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\LogSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */


//Para que funcione correctamente la activación y desactivación de la paginación se ha eliminado el Pjax

$this->title = Yii::t('app', 'Logs');
?>
<div class="log-index">

    <h1 class='mb-4'><?= Html::encode($this->title) ?></h1>

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?=Html::beginForm(['delete-seleccionados'], 'post', ['id' => 'deleteSeleccionados']);?>

    <p>

    <?php /* Html::a(Yii::t('app', $paginar ? 'Desactivar paginación': 'Activar paginación'), ['index','pagination' => $paginar ? '0' : '1'], ['class' => 'btn btn-success']) */?>

    <?= Html::a('Desactivar paginación',LogController::DesactivarPag($paginar ? false : true), ['class' => 'btn btn-success']) ?>

    <?= Html::submitButton('Eliminar seleccionados', [
        'class' => 'btn btn-danger',
        'data' => [ 'confirm' => '¿Estás seguro de que deseas eliminar los elementos seleccionados?'],
        'id' => 'deleteSeleccionados-boton',
        ]);?>
    
    <?= Html::a(Yii::t('app', 'Eliminar todos'), ['delete-all'], [
        'class' => 'btn btn-danger',
        'data' => [ 'confirm' => '¿Estás seguro de que deseas eliminar todos los elementos?'],
        ]);?>

    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => 'Mostrando ' . Html::tag('b', '{begin}-{end}') . ' de ' .  Html::tag('b', '{totalCount}') . ' elementos', //Para cambiar el idioma del texto del summary
        'emptyText' => 'No hay resultados',
        'pager' => [ 'class' => yii\bootstrap5\LinkPager::class ],
        'columns' => [
            [ 'class' => 'yii\grid\CheckboxColumn', 
            'checkboxOptions' => function ($model, $key, $index, $column) {
                return ['class' => 'your-checkbox-class'];
            }, ], //Para añadir un checkbox a cada linea

            'id',
            'level',
            'category',
            'log_time',
            'prefix:ntext',
            //'message:ntext',
            [
                'class' => ActionColumn::className(),
                'template' => '{view} {delete}', //Eliminar la opción de editar
                'urlCreator' => function ($action, Log $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],

        ],
    ]); ?>

    <?= Html::endForm();?> 


    
</div>

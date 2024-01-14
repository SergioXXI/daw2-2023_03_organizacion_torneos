<?php

use app\controllers\LogController;
use app\models\Log;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\LogSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */


//Para que funcione correctamente la activación y desactivación de la paginación se ha eliminado el Pjax

$this->title = Yii::t('app', 'Logs');
?>
<div class="log-index">

    <h1 class='mb-4'><?= Html::encode($this->title) ?></h1>

    <?php /* PRIMERA SECCIÓN, ESTO CORRESPONDE AL FORMULARIO INICIAL CON LOS FILTROS DE FECHA */ ?>

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    

    <?php /* TERCERA SECCIÓN, ESTO CORRESPONDE AL BOTÓN PARA ELIMINAR TODO CON FILTROS */ ?>

    <?=Html::beginForm(['boton-gestor'],'post');?>

    <?php /* SEGUNDA SECCIÓN, ESTO CORRESPONDE AL BOTÓN PARA DESACTIVAR PAGINACIÓN */ ?>

    <div class="mb-2">

        <?= Html::a('Exportar',['exportar'], ['class' => 'btn btn-dark']) ?>

        <?= Html::a('Desactivar paginación',LogController::DesactivarPag($paginar ? false : true), ['class' => 'btn btn-success']) ?>

        <?= Html::submitButton('Eliminar seleccionados', [
            'name' => 'accion',
            'value' => 'BtnEliminarSeleccionados',
            'class' => 'btn btn-danger',
            'onclick' => 'return confirm("¿Estás seguro de que deseas eliminar los elementos seleccionados?");',
            ]);?>  

        <?= Html::submitButton('Eliminar todos los filtrados', [
            'class' => 'btn btn-danger',
            'name' => 'accion',
            'value' => 'BtnEliminarFiltrados',
            'onclick' => 'return confirm("¿Estás seguro de que deseas eliminar todos los elementos filtrados?");',
            ]);?>

        <?= Html::submitButton('Eliminar todos', [
            'class' => 'btn btn-danger',
            'name' => 'accion',
            'value' => 'BtnEliminarTodos',
            'onclick' => 'return confirm("¿Estás seguro de que deseas eliminar TODOS los elementos?");',
            ]);?>
    </div>


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

            [
                'attribute' => 'level', 'value' => function ($model) {
                    return $model->level;
                },
                'filter' => Log::getListadoNiveles(),
                'filterInputOptions' => ['class' => 'form-select']
            ],

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

    <?= Html::hiddenInput('LogSearch[fecha_ini]', $searchModel->fecha_ini); ?>
    <?= Html::hiddenInput('LogSearch[fecha_fin]', $searchModel->fecha_fin); ?>
    <?= Html::hiddenInput('LogSearch[fecha_posterior]', $searchModel->fecha_posterior); ?>
    <?= Html::hiddenInput('LogSearch[fecha_anterior]', $searchModel->fecha_anterior); ?>

    <?= Html::endForm();?> 

    
</div>



<?php

use app\models\Direccion;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\DireccionSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Direcciones');
?>
<div class="direccion-index">

    <h1 class='mb-4'><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Crear Dirección'), ['create'], ['class' => 'btn btn-success']) ?>
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
            'calle',
            'numero',
            'cod_postal',
            'ciudad',
            'provincia',
            'pais',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Direccion $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 },
            ],
            
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>

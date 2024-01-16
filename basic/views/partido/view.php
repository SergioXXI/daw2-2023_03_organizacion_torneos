<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Partido $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Partidos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="partido-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php 
    if ((Yii::$app->user->can('admin'))||(Yii::$app->user->can('organizador'))||(Yii::$app->user->can('sysadmin'))) {
    echo '<p>'.
        Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary'])
        .Html::a(Yii::t('app', 'Actualizar Resultado'), ['actualizar-resultado', 'idPartido' => $model->id], ['class' => 'btn btn-primary']).
        Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ])
    .'</p>';

    echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'jornada',
            'fecha',
            'torneo_id',
            'reserva_id',
        ],
    ]) ;
    }else{
        echo DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'jornada',
                'fecha',
                'torneo_id',
                'reserva_id',
            ],
        ]) ;
    }
    
    ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Premio $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Premios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="premio-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
    <?php
        if ((Yii::$app->user->can('admin'))||(Yii::$app->user->can('organizador'))||(Yii::$app->user->can('sysadmin')))
        { 
            echo Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
            echo Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]);
        }
    ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nombre',
            'descripcion',
            'categoria_id',
            'torneo_id',
            'equipo_id',
        ],
    ]) ?>

<h2 class="mt-5 mb-4">Torneo</h2>


</div>

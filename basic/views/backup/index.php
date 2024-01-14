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

$this->title = Yii::t('app', 'Backup');

$icon = '<div class="input-group">{input}' . Html::submitButton('Restaurar Backup', ['class' => 'btn btn-warning']) . '</div>{error}';
?>

<div class="log-index">



    <h1 class='mb-4'><?= Html::encode($this->title) ?></h1>

    <?= Html::a('Crear Backup',['crear-backup'], ['class' => 'btn btn-success']) ?>
    <?= Html::a('Restaurar último backup',['restaurar-ultimo-backup'], ['class' => 'btn btn-dark']) ?>
    

    <?php $form = ActiveForm::begin(['action' => ['restaurar-backup'], 'options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'ficheroBackup', ['template' => $icon])->fileInput(['label' => false, 'class' => 'form-control']) ?>


    <?php ActiveForm::end(); ?>

    
</div>



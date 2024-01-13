<?php

use yii\helpers\Html;
use yii\web\View;
use yii\bootstrap5\ActiveForm;
use yii\jui\DatePicker;

$this->registerJsFile('https://kit.fontawesome.com/6a8d4512ef.js', ['position' => View::POS_HEAD]);

/** @var yii\web\View $this */
/** @var app\models\LogSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="log-search mb-4">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?php $icono = [
        'options' => ['class' => 'form-group position-relative'],
        'inputTemplate' => "<div class=\"position-relative\">{input}
          <i class=\"form-icon fa fa-calendar\"></i></div>"
    ]; ?>

    <div class="input-group d-flex gap-4 col-5">
        <?= $form->field($model,'fecha_ini', $icono)->widget(DatePicker::className(), [
            'dateFormat' => 'yyyy-MM-dd',
            'options' => ['class' => 'form-control', 'autocomplete' => 'off'],
        ]) ?>


        <?= $form->field($model,'fecha_fin', $icono)->widget(DatePicker::className(), [
            'dateFormat' => 'yyyy-MM-dd',
            'options' => ['class' => 'form-control', 'autocomplete' => 'off'],
        ]) ?>

    </div>


    <?= $form->field($model,'fecha_posterior', $icono)->widget(DatePicker::className(), [
        'dateFormat' => 'yyyy-MM-dd',
        'options' => ['class' => 'form-control', 'autocomplete' => 'off'],
    ]) ?>

    <?= $form->field($model,'fecha_anterior', $icono)->widget(DatePicker::className(), [
        'dateFormat' => 'yyyy-MM-dd',
        'options' => ['class' => 'form-control', 'autocomplete' => 'off'],
    ]) ?>

    <?php // echo $form->field($model, 'message') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Aplicar Filtros'), ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar filtros', ['index'], ['class' => 'btn btn-secondary',]) ?>
    </div>

    <?php ActiveForm::end(); ?>

    

</div>

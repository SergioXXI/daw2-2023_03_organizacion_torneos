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
            'data-pjax' => 1,
            'id' => 'Filtros',
        ],
    ]); ?>

    <?php $icono = [
        'options' => ['class' => 'form-group'],
        'inputTemplate' => "<div  class=\"input-group\">{input}
          <i class=\"input-group-text border-start-0 border-bottom-0 border ms-n5 fa fa-calendar\"></i>
      </div>"
    ]; ?>

    <div class="input-group">
        <?= $form->field($model,'fecha_ini', $icono)->widget(DatePicker::className(), [
            'dateFormat' => 'yyyy-MM-dd',
            'options' => ['class' => 'form-control'],
        ]) ?>

        <?= $form->field($model,'fecha_fin', $icono)->widget(DatePicker::className(), [
            'dateFormat' => 'yyyy-MM-dd',
            'options' => ['class' => 'form-control'],
        ]) ?>

    </div>



    <?= $form->field($model,'fecha_posterior', $icono)->widget(DatePicker::className(), [
        'dateFormat' => 'yyyy-MM-dd',
        'options' => ['class' => 'form-control'],
    ]) ?>

    <?= $form->field($model,'fecha_anterior', $icono)->widget(DatePicker::className(), [
        'dateFormat' => 'yyyy-MM-dd',
        'options' => ['class' => 'form-control'],
    ]) ?>

    <?php // echo $form->field($model, 'message') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Aplicar filtros'), ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar filtros', ['index'], ['class' => 'btn btn-secondary',]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

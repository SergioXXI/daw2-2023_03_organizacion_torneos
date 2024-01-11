<?php

use app\models\Direccion;
use app\models\Disciplina;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Pista $model */
/** @var yii\widgets\ActiveForm $form */
?>


<div class="pista-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre', ['options' => ['class' => 'needs-validation']])->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'disciplina_id')->dropDownList(Disciplina::getListadoDisciplinas(), ['prompt' => 'Seleccione una disciplina' ])->label('Disciplina'); ?>
    
    <?= Html::tag('p',"Dirección"); ?>

    <?= $form->field($model_direccion, 'calle')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model_direccion, 'numero')->textInput() ?>

    <?= $form->field($model_direccion, 'cod_postal')->textInput() ?>

    <?= $form->field($model_direccion, 'ciudad')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model_direccion, 'provincia')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model_direccion, 'pais')->textInput(['maxlength' => true]) ?>



    <?php //<?= $form->field($model, 'direccion_id')->dropDownList(Direccion::getListadoDirecciones(), ['prompt' => 'Seleccione una dirección' ])->label('Dirección'); ?>



    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

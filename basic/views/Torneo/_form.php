<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Torneo $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="torneo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'participantes_max')->textInput() ?>

    <?= $form->field($model, 'disciplina_id')->textInput() ?>

    <?= $form->field($model, 'tipo_torneo_id')->textInput() ?>

    <?= $form->field($model, 'clase_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

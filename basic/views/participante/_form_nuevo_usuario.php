<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;



// ...
/** @var yii\web\View $this */
/** @var app\models\Participante $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="participante-form">

    <?php 
    $form = ActiveForm::begin(); 
    ?>

    <?= $form->field($usuarioModel, 'nombre')->textInput(['maxlength' => true]);?>
    <?= $form->field($usuarioModel, 'apellido1')->textInput(['maxlength' => true]);?>
    <?= $form->field($usuarioModel, 'apellido2')->textInput(['maxlength' => true]);?>
    <?= $form->field($usuarioModel, 'email')->textInput(['maxlength' => true]);?>

    <?= $form->field($model, 'fecha_nacimiento')->widget(DatePicker::classname(), [
        'dateFormat' => 'yyyy-MM-dd',
        'options' => ['class' => 'form-control'],
    ]) ?>

    <?= $form->field($model, 'licencia')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tipo_participante_id')->dropDownList(
        $listaTiposParticipantes, 
        ['prompt' => 'Seleccione un Tipo de Participante']
    ) ?>

    <?= $form->field($model, 'imagen_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

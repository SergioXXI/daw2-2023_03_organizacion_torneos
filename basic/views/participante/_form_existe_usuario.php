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

    <?php $form = ActiveForm::begin(); ?>

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

    <?php if((Yii::$app->user->can('admin') || Yii::$app->user->can('sysadmin') || Yii::$app->user->can('gestor'))  && $idUser==null){?>
        <?= $form->field($model, 'usuario_id')->dropDownList(
            $listaUsuarios, 
            ['prompt' => 'Seleccione un Usuario']
        ) ?>
    <?php }else{?>
        <?= $form->field($model, 'usuario_id')->hiddenInput(['value' => $idUser])->label(false) ?>
    <?php } ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Guardar'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

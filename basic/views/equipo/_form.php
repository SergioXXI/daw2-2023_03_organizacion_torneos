<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Equipo $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="equipo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'licencia')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'categoria_id')->dropDownList(
        $listaCategorias, 
        ['prompt' => 'Selecciona una Categoría']
    ) ?>
    <?php    
    if ((Yii::$app->user->can('gestor')) || (Yii::$app->user->can('organizador')) || (Yii::$app->user->can('sysadmin')))  
        {?>
        <?= $form->field($model, 'creador_id')->dropDownList(
            $listaParticipantes, 
            ['prompt' => 'Selecciona un Lider']
        ) ?>
    <?php } else{?>
        <?= $form->field($model, 'creador_id')->hiddenInput(['value' => $participanteSesion->id])->label(false) ?>
    <?php } ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Guardar'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

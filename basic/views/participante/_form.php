<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Participante $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="participante-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fecha_nacimiento')->textInput() ?>

    <?= $form->field($model, 'licencia')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tipo_participante_id')->textInput() ?>

    <?= $form->field($model, 'imagen_id')->textInput() ?>

    <?= $form->field($model, 'usuario_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

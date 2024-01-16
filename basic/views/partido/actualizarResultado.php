<!-- views/partido/actualizarResultado.php -->

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
$idPartido = Yii::$app->request->get('idPartido', null);
$form = ActiveForm::begin(['action' => ['partido/actualizar-resultado', 'idPartido' => $model->idPartido]]);
?>

<?= $form->field($model, 'idPartido')->hiddenInput(['value' => $idPartido])->label(false) ?>

<?= $form->field($model, 'idEquipo1')->textInput(['type' => 'number']) ?>

<?= $form->field($model, 'puntosEquipo1')->textInput(['type' => 'number']) ?>

<?= $form->field($model, 'idEquipo2')->textInput(['type' => 'number']) ?>

<?= $form->field($model, 'puntosEquipo2')->textInput(['type' => 'number']) ?>

<div class="form-group">
    <?= Html::submitButton('Actualizar Resultado', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>

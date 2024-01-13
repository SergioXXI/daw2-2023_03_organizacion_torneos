<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\ReservaPista $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="container">
        <?php $form = ActiveForm::begin(); ?>

        <div class="row">
            <div class="card mb-4">
                <div class="card-body">
                    <h3 class="h5 mb-3">Reserva Pista</h3>
                    <?= $form->field($model, 'reserva_id')->textInput() ?>
                    <?= $form->field($model, 'pista_id')->textInput() ?>
                </div>
            </div>
        </div>
           
    </div>

    <div class="form-group text-end me-2">
        <?= Html::a('Cancelar', ['index'], ['class' => 'btn btn-secondary pe-3 mx-1']) ?>
        <?= Html::submitButton(Yii::t('app', 'Guardar'), ['class' => 'btn btn-success pe-3 mx-1']) ?>
    </div>

    <?php ActiveForm::end(); ?>


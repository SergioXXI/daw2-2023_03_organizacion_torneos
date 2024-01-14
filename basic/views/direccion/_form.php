<?php

use app\models\Direccion;
use app\models\Disciplina;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\YourModel */
/* @var $form yii\widgets\ActiveForm */
?>

    <div class="container">
        <?php $form = ActiveForm::begin(); ?>

        <div class="row">
            <div class="card mb-4">
                <div class="card-body">
                    <h3 class="h5 mb-3">Dirección</h3>
                    <?= $form->field($model, 'calle')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'numero')->textInput() ?>
                    <?= $form->field($model, 'cod_postal')->textInput() ?>
                    <?= $form->field($model, 'ciudad')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'provincia')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'pais')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group text-end me-2">
        <?= Html::a('Cancelar', ['index'], ['class' => 'btn btn-secondary pe-3 mx-1']) ?>
        <?= Html::submitButton(Yii::t('app', 'Guardar'), ['class' => 'btn btn-success pe-3 mx-1']) ?>
    </div>

        <?php ActiveForm::end(); ?>
    


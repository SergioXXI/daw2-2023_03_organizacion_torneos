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

        <!-- Main content -->
        <div class="row">
            <!-- Left side -->
                <!-- Basic information -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h3 class="h5 mb-3">Pista</h3>
                        <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'disciplina_id')->dropDownList(Disciplina::getListadoDisciplinas(), ['prompt' => 'Seleccione una disciplina' ])->label('Disciplina'); ?>
                    </div>
                </div>
                <!-- Address -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h3 class="h5 mb-3">Dirección</h3>
                        <?= $form->field($model_direccion, 'calle')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model_direccion, 'numero')->textInput() ?>
                        <?= $form->field($model_direccion, 'cod_postal')->textInput() ?>
                        <?= $form->field($model_direccion, 'ciudad')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model_direccion, 'provincia')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model_direccion, 'pais')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
            </div>
           
        </div>

        <div class="form-group text-end me-2">
            <?= Html::a('Cancelar', ['list'], ['class' => 'btn btn-secondary pe-3 mx-1']) ?>
            <?= Html::submitButton(Yii::t('app', 'Guardar'), ['class' => 'btn btn-success pe-3 mx-1']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

<?php

use app\models\Direccion;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Pista $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="pista-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

    <?php $var = ArrayHelper::map(Direccion::find()->all(), 'id', 'direccionCompleta'); ?>

    <?= $form->field($model, 'direccion_id')->dropDownList($var, ['prompt' => 'Seleccione una dirección' ])->label('Dirección'); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

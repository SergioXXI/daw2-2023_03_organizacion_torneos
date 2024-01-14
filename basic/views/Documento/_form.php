<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Documento $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="documento-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ruta')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

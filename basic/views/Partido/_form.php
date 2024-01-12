<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\torneo;

/** @var yii\web\View $this */
/** @var app\models\Partido $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="partido-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'jornada')->textInput() ?>

    <br/>
    <?= $form->field($model, 'fecha')->widget(\yii\jui\DatePicker::classname(), ['dateFormat' => 'yyyy-MM-dd'],) ?>
    <br/>

    <?= $form->field($model, 'torneo_id')->dropDownList(
        \yii\helpers\ArrayHelper::map(torneo::find()->all(), 'id', 'nombre'),
        ['prompt' => 'Selecciona un torneo']
    ) ?>

    <?= Html::submitButton(Yii::t('app', 'Hacer una reserva'), ['class' => 'btn btn-success','name' => 'reserva_button']) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success','name' => 'save_button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use app\models\Equipo;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\torneo;



/** @var yii\web\View $this */
/** @var app\models\Partido $model */
/** @var app\models\PartidoEquipo $model_equipo */
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
    <?= $form->field($model, 'direccion_id')->textInput() ?>
    
    <?= $form->field($model_equipo, 'equipo_id')->dropDownList(
        \yii\helpers\ArrayHelper::map(Equipo::find()->all(), 'id', 'nombre'),
        ['prompt' => 'Selecciona un Equipo']
    ) ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use app\models\Disciplina;
use app\models\TipoTorneo;
use app\models\Clase;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Torneo $model */
/** @var yii\widgets\ActiveForm $form */

$disciplina = Disciplina::find()
    ->indexBy('id')
    ->all();
?>

<div class="torneo-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'participantes_max')->textInput() ?>

    <?= $form->field($model, 'disciplina_id')->dropDownList(
    \yii\helpers\ArrayHelper::map(Disciplina::find()->all(), 'id', 'nombre'),
    ['prompt' => 'Select Discipline']
    ) ?>

    <?= $form->field($model, 'tipo_torneo_id')->dropDownList(
        \yii\helpers\ArrayHelper::map(TipoTorneo::find()->all(), 'id', 'nombre'),
        ['prompt' => 'Select Discipline']
    ) ?>

<?= $form->field($model, 'clase_id')->dropDownList(
        \yii\helpers\ArrayHelper::map(Clase::find()->all(), 'id', 'titulo'),
        ['prompt' => 'Select Discipline']
    ) ?>
    <br/>
    <?= $form->field($model, 'fecha_inicio')->widget(\yii\jui\DatePicker::classname(), ['dateFormat' => 'yyyy-MM-dd'],) ?>
    <br/>
    <?= $form->field($model, 'fecha_limite')->widget(\yii\jui\DatePicker::classname(), ['dateFormat' => 'yyyy-MM-dd']) ?>
    <br/>
    <?= $form->field($model, 'imageFile')->fileInput() ?>
    <br/><br/>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

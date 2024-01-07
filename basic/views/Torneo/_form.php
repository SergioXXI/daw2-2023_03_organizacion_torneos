<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Disciplina;
use app\models\Clase;
use app\models\TipoTorneo;

/** @var yii\web\View $this */
/** @var app\models\Torneo $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="torneo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'participantes_max')->textInput() ?>
    <?php
        
        $lista_disciplina = Disciplina::find()->select(['id','nombre'])->asArray()->all();
        // Generating the dropdown list
        echo $form->field($model, 'disciplina_id')->dropDownList( \yii\helpers\ArrayHelper::map($lista_disciplina, 'id', 'nombre'), ['prompt' => 'Select Option']);
        echo '<br>';
    ?>

    <?php
        $lista_tipo_torneo = TipoTorneo::find()->select(['id','nombre'])->asArray()->all();
        // Generating the dropdown list
        echo $form->field($model, 'tipo_torneo_id')->dropDownList( \yii\helpers\ArrayHelper::map($lista_tipo_torneo, 'id', 'nombre'), ['prompt' => 'Select Option']);
        echo '<br>';
    ?>

    <?php

        $lista_clase = Clase::find()->select(['id','titulo'])->asArray()->all();
        // Generating the dropdown list
        echo $form->field($model, 'clase_id')->dropDownList( \yii\helpers\ArrayHelper::map($lista_clase, 'id', 'titulo'), ['prompt' => 'Select Option']);
        echo '<br>';
    ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

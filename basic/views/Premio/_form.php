<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Categoria;
use app\models\Torneo;
/** @var yii\web\View $this */
/** @var app\models\Premio $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="premio-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'categoria_id')->dropDownList(
    \yii\helpers\ArrayHelper::map(Categoria::find()->all(), 'id', 'nombre'),
    ['prompt' => 'Select Discipline']
    ) ?>

<?= $form->field($model, 'torneo_id')->dropDownList(
    \yii\helpers\ArrayHelper::map(Torneo::find()->all(), 'id', 'nombre'),
    ['prompt' => 'Select Discipline']
    ) ?>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

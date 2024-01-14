<?php

use app\models\Equipo;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\TorneoEquipo;



/** @var yii\web\View $this */
/** @var app\models\Partido $id */
/** @var app\models\Partido $model_equipo1 */
/** @var app\models\Partido $model_equipo2 */

/** @var yii\widgets\ActiveForm $form */
?>

<div class="Equipos-form">

    <?php $form = ActiveForm::begin(); ?>

   

    <?= $form->field($model_equipo1, 'equipo_id')->dropDownList(
        \yii\helpers\ArrayHelper::map(TorneoEquipo::find()->where(['torneo_id' => $id])->joinWith('equipo') // Assuming there's a relation named 'equipo'
        ->all(), 'equipo_id', 'equipo.nombre'),
        ['prompt' => 'Selecciona un equipo']
    ) ?>
    <?= $form->field($model_equipo2, 'equipo_id')->dropDownList(
        \yii\helpers\ArrayHelper::map(TorneoEquipo::find()->where(['torneo_id' => $id])->joinWith('equipo') // Assuming there's a relation named 'equipo'
        ->all(), 'equipo_id', 'equipo.nombre'),
        ['prompt' => 'Selecciona un equipo']
    ) ?>
    

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

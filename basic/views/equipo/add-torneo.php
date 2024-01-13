<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Equipo $model */
/** @var array $listaTorneos */

$this->title = 'Unirse a un Torneo';
$this->params['breadcrumbs'][] = ['label' => 'Equipos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="equipo-join-torneo">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->dropDownList($listaTorneos, ['prompt' => 'Seleccione un Torneo']) ?>

    <div class="form-group">
        <?= Html::submitButton('Unirse', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
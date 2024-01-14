<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Equipo $equipoModel */
/** @var array $listaEquipos */

$this->title = 'Selector de equipos';
$this->params['breadcrumbs'][] = ['label' => 'Participantes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div>
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($equipoModel, 'id')->dropDownList($listaEquipos, ['prompt' => 'Seleccione un Equipo']) ?>

    <div class="form-group">
        <?= Html::submitButton('Añadir', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); 
    echo Html::a('Volver', Yii::$app->request->referrer ?: ['site/index'], ['class' => 'btn btn-primary']);
    ?>
</div>

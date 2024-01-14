<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Participante $model */

$this->title = Yii::t('app', 'Create Participante');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Participantes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="participante-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>
        <?= Html::submitButton('Usuario Existente', ['name' => 'userType', 'value' => 'existing', 'class' => 'btn btn-primary']) ?>
        <?= Html::submitButton('Nuevo Usuario', ['name' => 'userType', 'value' => 'new', 'class' => 'btn btn-secondary']) ?>
    <?php ActiveForm::end(); ?>
    
    <?php if ($userType === 'existing'): ?>
        <?= $this->render('_form_existe_usuario', [
            'model' => $model,
            'listaTiposParticipantes' => $listaTiposParticipantes,
            'listaUsuarios' => $listaUsuarios,
        ]) ?>
    <?php elseif ($userType === 'new'): ?>
        <?= $this->render('_form_nuevo_usuario', [
            'model' => $model,
            'listaTiposParticipantes' => $listaTiposParticipantes,
            'usuarioModel' => $usuarioModel,
        ]) ?>
    <?php endif; ?>
</div>

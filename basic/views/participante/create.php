<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Participante $model */

$this->title = Yii::t('app', 'Create Participante');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Participantes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="participante-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div id="user-selection">
        <p>¿Es el participante un usuario existente en la web?</p>
        <?= Html::button('Sí', ['class' => 'btn btn-primary', 'id' => 'existing-user']) ?>
        <?= Html::button('No', ['class' => 'btn btn-secondary', 'id' => 'new-user']) ?>
    </div>

    <div id="existing-user-form" style="display:none;">
        <?= $this->render('_form_existe_usuario', [
            'model' => $model,
            'listaTiposParticipantes' => $listaTiposParticipantes,
            'listaUsuarios' => $listaUsuarios,
        ]) ?>
    </div>

    <div id="new-user-form" style="display:none;">
        <?= $this->render('_form_nuevo_usuario', [
            'model' => $model,
            'listaTiposParticipantes' => $listaTiposParticipantes,
            'usuarioModel' => $usuarioModel,
        ]) ?>
    </div>
</div>

<script>
    document.getElementById('existing-user').addEventListener('click', function() {
        document.getElementById('existing-user-form').style.display = 'block';
        document.getElementById('new-user-form').style.display = 'none';
    });

    document.getElementById('new-user').addEventListener('click', function() {
        document.getElementById('new-user-form').style.display = 'block';
        document.getElementById('existing-user-form').style.display = 'none';
    });
</script>
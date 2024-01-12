<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Iniciar Sesión';
?>

<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Por favor, complete los siguientes campos para iniciar sesión:</p>

    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

    <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <?php if ($model->hasErrors('email')): ?>
        <div class="alert alert-danger">
            <?= $model->getFirstError('email') ?>
        </div>
    <?php endif; ?>

    <?php if ($model->hasErrors('password')): ?>
        <div class="alert alert-danger">
            <?= $model->getFirstError('password') ?>
        </div>
    <?php endif; ?>

    <div class="form-group">
        <?= Html::submitButton('Iniciar Sesión', ['class' => 'btn btn-success', 'name' => 'login-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>



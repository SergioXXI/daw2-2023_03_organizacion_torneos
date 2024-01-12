<?php
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Registro';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-register">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(['id' => 'register-form']); ?>

    <?= $form->field($model, 'nombre')->textInput(['autofocus' => true]) ?>

    <?= $form->field($model, 'apellido1') ?>

    <?= $form->field($model, 'apellido2') ?>

    <?= $form->field($model, 'email') ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <?php
    // Mostrar el campo 'admin' solo si el usuario tiene el rol 'sysadmin'
    if (Yii::$app->user->can('sysadmin')) {
        echo $form->field($model, 'rol')->dropDownList([
            'admin' => 'Administrador',
            'gestor' => 'Gestor',
            'organizador' => 'Organizador',
            'usuario' => 'Usuario',
        ], ['prompt' => 'Selecciona un rol']);
    }elseif (Yii::$app->user->can('admin')) {
        echo $form->field($model, 'rol')->dropDownList([
            'gestor' => 'Gestor',
            'organizador' => 'Organizador',
            'usuario' => 'Usuario',
        ], ['prompt' => 'Selecciona un rol']);
    }
    ?>

    <div class="form-group">
        <?= Html::submitButton('Registrarse', ['class' => 'btn btn-primary', 'name' => 'register-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

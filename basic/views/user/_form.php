<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper; // Add this line to import the ArrayHelper class

/** @var yii\web\View $this */
/** @var app\models\User $model */
/** @var yii\widgets\ActiveForm $form */

$rolesUsuario = Yii::$app->authManager->getRolesByUser($model->id);
// Se supone que cada usuario solo tiene un rol
$rolUsuario = !empty($rolesUsuario) ? reset($rolesUsuario) : null;

?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= Yii::$app->user->isGuest && (Yii::$app->user->can('admin') || Yii::$app->user->can('sysadmin')) 
        ? $form->field($model, 'id')->textInput()
        : null ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'apellido1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'apellido2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

    <?= Yii::$app->user->can('admin') || Yii::$app->user->can('sysadmin') 
            ? $form->field($model, 'rol')->dropDownList(
                ArrayHelper::map($roles, 'name', 'name'),
                // Ponemos el rol del usuario como seleccionado
                ['options' => [$rolUsuario ? $rolUsuario->name : null => ['selected' => true]]]) 
            : '' ?>



    <br><div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

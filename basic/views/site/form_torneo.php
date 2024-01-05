<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre') ?>

    <?= $form->field($model, '$descripcion') ?>

    <?= $form->field($model, '$participantes_max') ?>
    
    <?= $form->field($model, '$disciplina_id') ?>

    <?= $form->field($model, '$tipo_torneo_id') ?>

    <?= $form->field($model, '$clase_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm; 

?>

<?php
$form = ActiveForm::begin([
    'method' => 'get',
    'action' => ['pistas'], 
]); 
?>

<?= $form->field($model, 'busquedaGlobal') ?>


<div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Buscar'), ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
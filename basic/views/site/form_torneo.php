<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre') ?>

    <?= $form->field($model, 'descripcion') ?>
    
    <?php

    // Sample data for dropdown options
    $disciplina_id = [
        '1' => 'Futbol',
        '2' => 'Baloncesto',
        '3' => 'Tenis',
    ];

    // Generating the dropdown list
    echo Html::dropDownList('dropdownName', null, $disciplina_id, ['prompt' => 'Select Option']);
    echo '<br><br>';
    $tipo_torneo_id = [
        '1' => 'Eliminatorias',
        '2' => 'Liga',
        '3' => 'Amistoso',
    ];
    

    // Generating the dropdown list
    echo Html::dropDownList('dropdownName', null, $tipo_torneo_id, ['prompt' => 'Select Option']);
    echo '<br><br>';
    $clase_id = [
        '1' => 'Nacional',
        '2' => 'Local',
        '3' => 'Intenacional',
    ];

    // Generating the dropdown list
    echo Html::dropDownList('dropdownName', null, $clase_id, ['prompt' => 'Select Option']);
    echo '<br><br>';
    
?>


    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>
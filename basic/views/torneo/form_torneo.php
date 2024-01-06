<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre') ?>

    <?= $form->field($model, 'descripcion') ?>

    <?= $form->field($model, 'participantes_max') ?>
    
    <?php
        echo '<br>';
        // Sample data for dropdown options
        $lista_disciplina = [
            '1' => 'Futbol',
            '2' => 'Baloncesto',
            '3' => 'Tenis',
        ];

        // Generating the dropdown list
        echo $form->field($model, 'disciplina_id')->dropDownList($lista_disciplina, ['prompt' => 'Select Option']);
        echo '<br><br>';
        $lista_tipo_torneo = [
            '1' => 'Eliminatorias',
            '2' => 'Liga',
            '3' => 'Amistoso',
        ];
        

        // Generating the dropdown list
        echo $form->field($model, 'tipo_torneo_id')->dropDownList($lista_tipo_torneo, ['prompt' => 'Select Option']);
        echo '<br><br>';
        $lista_clase = [
            '1' => 'Nacional',
            '2' => 'Local',
            '3' => 'Intenacional',
        ];

        // Generating the dropdown list
        echo $form->field($model, 'clase_id')->dropDownList($lista_clase, ['prompt' => 'Select Option']);
        echo '<br><br>';
    
    ?>


    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>
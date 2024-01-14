<?php

use yii\widgets\ActiveForm;
use app\models\Disciplina;
use app\widgets\BuscadorWidget;

?>

<?php
$form = ActiveForm::begin([
    'method' => 'get',
    'action' => ['index'], 
]); 

?>



<?= BuscadorWidget::widget([
    'form' => $form,
    'model' => $model,
    'atributoPredeterminado' => 'nombre',
    'campos' => [
        ['atributo' => 'participantes_max', 'tipo' => 'text', 'placeholder' => 'Introduzca el número máximo de participantes'],
    ],
]); ?>



<?php ActiveForm::end(); ?>
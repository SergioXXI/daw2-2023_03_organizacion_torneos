<?php

use yii\widgets\ActiveForm;
use app\models\Disciplina;
use app\widgets\BuscadorWidget;

?>

<?php
$form = ActiveForm::begin([
    'method' => 'get',
    'action' => ['pistas'], 
]); 

?>



<?= BuscadorWidget::widget([
    'form' => $form,
    'model' => $model,
    'campos' => [
        ['atributo' => 'direccionProvincia', 'tipo' => 'text', 'placeholder' => 'Introduzca una provincia'],
        ['atributo' => 'direccionCiudad', 'tipo' => 'text', 'placeholder' => 'Introduzca una ciudad'],
        ['atributo' => 'direccionPais', 'tipo' => 'text', 'placeholder' => 'Introduzca una provincia'],
        ['atributo' => 'disciplinaNombre', 'tipo' => 'dropdown', 'opciones' => Disciplina::getListadoDisciplinasPorNombre() ,'placeholder' => 'Seleccione una disciplina'],
    ],
]); ?>



<?php ActiveForm::end(); ?>
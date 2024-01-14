<?php

use yii\widgets\ActiveForm;
use app\models\Disciplina;
use app\models\Clase;
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
    'model' => $torneoSearch,
    'atributoPredeterminado' => 'nombre',
    'campos' => [
        ['atributo' => 'disciplina_id', 'tipo' => 'dropdown', 'opciones' => Disciplina::getListadoDisciplinasPorId() , 'placeholder' => 'Seleccione una disciplina'],
        ['atributo' => 'clase_id', 'tipo' => 'dropdown', 'opciones' => Clase::getListadoClasePorId() , 'placeholder' => 'Seleccione una clase'],
        ['atributo' => 'jornada', 'tipo' => 'number', 'placeholder' => 'Introduzca el número de jornada'],
    ],
]); ?>




<?php ActiveForm::end(); ?>
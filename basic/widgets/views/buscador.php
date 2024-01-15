<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<?php

$icon = '<div class="position-relative">{input}<i class="fas fa-search form-icon"></i></div>';

//Se comprueba si el apartado de filtros tiene que estar abierto
//por predeterminado está cerrado pero si llega algun campo de los filtros
//con valor no vacio se abre
$abierto = false;
foreach($campos as $campo) {
    $atributo = $campo['atributo'];
    //Acceso al atributo del modelo mediante la string contenido en $campo['atributo']
    if(!empty($model->$atributo)) {
        $abierto = true;
        break;
    }
}

?>

<div class="search-bar shadow p-3 mb-5 bg-body rounded w-75 mx-auto">
    <div class="busqueda-global row px-3">
        <?php //Se incluye la variable $campoPredeterminado correspondiente a la busqueda genérica ?> 
        <div class="col mx-1 px-0"><?= $form->field($model, $atributoPredeterminado, ['template' => $icon])->textInput(['placeholder' => 'Introduzca un término de búsqueda']) ?></div>
        <div class="col-auto mx-1 px-0"><?= Html::a('Eliminar filtros', [''], ['class' => 'btn btn-outline-secondary fw-bold shadow-sm',]) ?></div>
        <div class="col-auto mx-1 px-0"><?= Html::submitButton(Yii::t('app', 'Buscar'), ['class' => 'btn btn-success fw-bold shadow-sm']) ?></div>
    </div>
    <?php if ($filtros) { ?>
        <div class="form-group mx-2 mt-2 mb-0">
            <details <?= $abierto ? 'open' : '' ?>>
            <summary class="text-center btn btn-success fw-bold shadow-sm">Filtros avanzados</summary>
            <fieldset id="filtros">
                <div class="busqueda-filtros">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 mt-0">
                        <?php 
                            foreach($campos as $campo) {
                                //Imprimir el input correspondiente al valor de $campo['tipo']
                                switch ($campo['tipo']) {
                                    case 'text':
                                        echo $form->field($model, $campo['atributo'], ['template' => '{input}', 'options' => ['class' => 'col px-2']])->textInput(['placeholder' => $campo['placeholder']]);
                                        break;
                                    case 'dropdown':
                                        echo $form->field($model, $campo['atributo'], ['template' => '{input}', 'options' => ['class' => 'col px-2']])->dropDownList($campo['opciones'], [
                                            'prompt' => $campo['placeholder'],
                                            'class' => 'form-select',
                                        ]);
                                        break;
                                    case 'number':
                                        echo $form->field($model, $campo['atributo'], ['template' => '{input}', 'options' => ['class' => 'col px-2']])->textInput(['placeholder' => $campo['placeholder'], 'type' => 'number']);
                                        break;
                                    default:
                                        break;
                                }
                            }
                        ?>
                    </div>
                </div>
            </fieldset>
            </details>
        </div>
    <?php }; ?>
</div>

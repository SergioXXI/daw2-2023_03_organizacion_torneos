<?php

namespace app\widgets;
use yii\base\Widget;

class BuscadorWidget extends Widget
{
    public $campos = [];
    public $filtros = true;
    public $model;
    public $form;
    //Atributo del model de busqueda usado para la busqueda global por términos
    //En este caso el valor predeterminado de este atributo es busquedaGlobal
    public $atributoPredeterminado = 'busquedaGlobal'; 

    public function run()
    {
        return $this->render('buscador', [
            'form' => $this->form,
            'model' => $this->model,
            'campos' => $this->campos,
            'atributoPredeterminado' => $this->atributoPredeterminado,
            'filtros' => $this->filtros,
        ]);
    }
}

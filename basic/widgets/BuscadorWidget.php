<?php

namespace app\widgets;
use yii\base\Widget;

//widget que permite pasados unos parametros sencilos generar una vista correspondiente a un barra de búsqueda que incluye filtros avanzados,
//Este widget puede ser reutilizado por cualquier modelo ya que las cosas particulares de los campos son añadidas mediante parametros y el número de filtros no está restringido
class BuscadorWidget extends Widget
{
    //Array que contendra los atributos de cada campo o filtro a aplicar
    /*Ejemplo: 'campos' => [
        ['atributo' => 'direccionProvincia', 'tipo' => 'text', 'placeholder' => 'Introduzca una provincia'],
    ]*/
    public $campos = []; 
    //Variable que determina si se van a añadir filtros avanzados, true por defecto
    public $filtros = true;
    //Modelo de busqueda a utilizar
    public $model;
    //Variable del formulario donde se van a introducir los fields(), debe ser ActiveForm
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

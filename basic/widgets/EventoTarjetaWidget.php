<?php

namespace app\widgets;
use yii\base\Widget;

//widget que permite pasados unos parametros imprimir una tarjeta de evento
class EventoTarjetaWidget extends Widget
{
    //Id del evento utilizada en caso de necesitar redirigir a vistas
    public $id = null;
    //Datos que se van a mostrar en la tarjeta
    public $datos = [];
    //Bool que determina si se debe añadir un botón de información
    public $botonInfo = true;
    //String con el tipo de tarjeta mostrada, puede ser ampliada o normal
    public $tarjetaEvento = 'normal';

    public function run()
    {
        $vista = ($this->tarjetaEvento === 'normal') ? 'tarjeta-evento' : 'tarjeta-evento_ampliada';
        return $this->render($vista, [
            'id' => $this->id,
            'datos' => $this->datos,
            'botonInfo' => $this->botonInfo,
        ]);
    }
}

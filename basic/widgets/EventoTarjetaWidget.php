<?php

namespace app\widgets;
use yii\base\Widget;

class EventoTarjetaWidget extends Widget
{
    public $id = null;
    public $datos = [];
    public $botonInfo = true;
    public $resaltar = false;
    public $tarjetaEvento = 'normal';

    public function run()
    {
        $vista = ($this->tarjetaEvento === 'normal') ? 'tarjeta-evento' : 'tarjeta-evento_ampliada';
        return $this->render($vista, [
            'id' => $this->id,
            'datos' => $this->datos,
            'botonInfo' => $this->botonInfo,
            'resaltar' => $this->resaltar,
        ]);
    }
}

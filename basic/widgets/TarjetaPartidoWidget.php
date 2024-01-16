<?php

namespace app\widgets;
use yii\base\Widget;

//widget que permite pasados unos parametros imprimir una tarjeta de evento
class TarjetaPartidoWidget extends Widget
{
    //Id del evento utilizada en caso de necesitar redirigir a vistas
    public $partido;
    public $equipos;
    public $partidoEquipos;

    public function run()
    {
        return $this->render('tarjeta-partido', [
            'partido' => $this->partido,
            'equipos' => $this->equipos,
            'partidoEquipos' => $this->partidoEquipos,
        ]);
    }
}

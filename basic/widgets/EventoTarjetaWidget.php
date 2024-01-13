<?php

namespace app\widgets;
use yii\base\Widget;

class EventoTarjetaWidget extends Widget
{
    public $id = null;
    public $titulo;
    public $fecha;
    public $botonInfo = true;
    public $resaltar = false;

    public function run()
    {
        return $this->render('tarjeta-evento', [
            'id' => $this->id,
            'titulo' => $this->titulo,
            'fecha' => $this->fecha,
            'botonInfo' => $this->botonInfo,
            'resaltar' => $this->resaltar,
        ]);
    }
}

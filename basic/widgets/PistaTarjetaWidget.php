<?php

namespace app\widgets;
use yii\base\Widget;

//widget que permite pasados unos parametros imprimir una tarjeta de pista
class PistaTarjetaWidget extends Widget
{
    //Modelo pista a utilizar en la tarjeta
    public $model;

    public function run()
    {
        return $this->render('tarjeta-pista', [
            'model' => $this->model,
        ]);
    }
}

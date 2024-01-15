<?php

namespace app\widgets;
use yii\base\Widget;

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

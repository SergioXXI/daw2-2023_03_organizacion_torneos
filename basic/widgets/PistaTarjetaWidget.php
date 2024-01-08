<?php

namespace app\widgets;
use yii\base\Widget;

class PistaTarjetaWidget extends Widget
{
    public $model;

    public function run()
    {
        return $this->render('tarjeta-pista', [
            'model' => $this->model,
        ]);
    }
}

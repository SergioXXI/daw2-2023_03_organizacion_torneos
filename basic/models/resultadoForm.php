<?php

namespace app\models;

use yii\base\Model;

class ResultadoForm extends Model
{
    public $idPartido;
    public $idEquipo1;
    public $idEquipo2;
    public $puntosEquipo1;
    public $puntosEquipo2;

    public function rules()
    {
        return [
            [['idPartido', 'idEquipo1', 'idEquipo2', 'puntosEquipo1', 'puntosEquipo2'], 'required'],
            [['idPartido','idEquipo1', 'idEquipo2', 'puntosEquipo1', 'puntosEquipo2'], 'integer'],
        ];
    }
}

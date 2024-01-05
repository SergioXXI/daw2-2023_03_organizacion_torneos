<?php
namespace app\models;

use yii;
use yii\base\Model;

class torneo extends Model
{
    public $nombre;
    public $descripcion;
    public $participantes_max;
    public $disciplina_id;//1-futbol,2-balencesto, 3-tenis
    public $tipo_torneo_id;//1-Eliminatorias,2-Liga, 3-Amistoso
    public $clase_id;//1-Nacional,2-local, 3-Intenacional
    public function rules()
    {
        return[
            [['nombre','participantes_max','disciplina_id','tipo_torneo_id','clase_id'],'required'],
        ];
    }
}
?>
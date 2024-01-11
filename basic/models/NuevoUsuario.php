<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class NuevoUsuario extends ActiveRecord
{
    public $rol;
    
    public static function tableName()
    {
        return 'usuario';
    }
    
    public static function primaryKey()
    {
        return ['id'];
    }

    public function rules()
    {
        return [
            [['nombre', 'apellido1', 'apellido2', 'email', 'password'], 'required'],
            ['email', 'email'],
            ['email', 'unique', 'message' => 'Este email ya está en uso.'],
            ['password', 'string'],
            ['rol', 'safe'],
        ];
    }
}

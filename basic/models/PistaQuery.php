<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Pista]].
 *
 * @see Pista
 */
class PistaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Pista[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Pista|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /* 
     * Función que devuelve una expresión sql en formato string para poder ser utilizada durante el filtrado
     * En este caso se genera una dirección uniendo todos los campos para asi poder buscar de forma global
     * Se devuelve solo este segmento string para poder ser utilizada en diversos operadores como and,or...
    */
    public function porDireccionCompleta($direccionCompleta)
    {
        $expresion = 'CONCAT(calle, " ", numero, ", ", ciudad, ", ", provincia, ", ", pais, ", CP: ", cod_postal)';
        return $expresion;
    }

}

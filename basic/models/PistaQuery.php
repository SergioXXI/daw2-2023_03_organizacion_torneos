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
<<<<<<< HEAD

    //Devuelve la expresión a utilizar dentro de la query, hecho así para unificar frente a busquedas con distintos operadores
    public function porDireccionCompleta($direccionCompleta)
    {
        $expresion = 'CONCAT(calle, " ", numero, ", ", ciudad, ", ", provincia, ", ", pais, ", CP: ", cod_postal)';
        //$this->andFilterWhere(['like', $expresion , $direccionCompleta]);
        return $expresion;
    }

=======
>>>>>>> origin/G2-Torneos
}

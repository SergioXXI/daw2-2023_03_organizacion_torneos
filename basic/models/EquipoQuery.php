<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Equipo]].
 *
 * @see Equipo
 */
class EquipoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * Función que lista todos los modelos que haya
     * {@inheritdoc}
     * @return Equipo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * Función que solo lista un modelo de los que haya
     * {@inheritdoc}
     * @return Equipo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[PartidoEquipo]].
 *
 * @see PartidoEquipo
 */
class PartidoEquipoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return PartidoEquipo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return PartidoEquipo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

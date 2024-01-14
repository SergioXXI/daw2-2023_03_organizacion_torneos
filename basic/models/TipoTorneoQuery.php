<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[TipoTorneo]].
 *
 * @see TipoTorneo
 */
class TipoTorneoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return TipoTorneo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return TipoTorneo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

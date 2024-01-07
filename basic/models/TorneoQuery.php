<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Torneo]].
 *
 * @see Torneo
 */
class TorneoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Torneo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Torneo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

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
}

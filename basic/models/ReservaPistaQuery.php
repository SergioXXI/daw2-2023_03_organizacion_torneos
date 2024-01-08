<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[ReservaPista]].
 *
 * @see ReservaPista
 */
class ReservaPistaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ReservaPista[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ReservaPista|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

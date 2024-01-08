<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[ReservaMaterial]].
 *
 * @see ReservaMaterial
 */
class ReservaMaterialQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ReservaMaterial[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ReservaMaterial|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

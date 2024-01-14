<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Normativa]].
 *
 * @see Normativa
 */
class NormativaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Normativa[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Normativa|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[TorneoNormativa]].
 *
 * @see TorneoNormativa
 */
class TorneoNormativaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return TorneoNormativa[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return TorneoNormativa|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

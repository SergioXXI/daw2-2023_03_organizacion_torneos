<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Participante]].
 *
 * @see Participante
 */
class ParticipanteQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Participante[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Participante|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

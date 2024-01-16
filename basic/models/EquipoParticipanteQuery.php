<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[EquipoParticipante]].
 *
 * @see EquipoParticipante
 */
class EquipoParticipanteQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return EquipoParticipante[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return EquipoParticipante|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

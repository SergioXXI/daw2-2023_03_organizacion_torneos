<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[TorneoEquipo]].
 *
 * @see TorneoEquipo
 */
class TorneoEquipoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return TorneoEquipo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return TorneoEquipo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

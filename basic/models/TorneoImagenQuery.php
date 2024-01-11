<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[TorneoImagen]].
 *
 * @see TorneoImagen
 */
class TorneoImagenQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return TorneoImagen[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return TorneoImagen|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

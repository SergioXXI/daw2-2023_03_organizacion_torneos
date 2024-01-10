<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Clase]].
 *
 * @see Clase
 */
class ClaseQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Clase[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Clase|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

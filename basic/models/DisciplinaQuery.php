<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Disciplina]].
 *
 * @see Disciplina
 */
class DisciplinaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Disciplina[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Disciplina|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}

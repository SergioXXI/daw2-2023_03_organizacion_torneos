<?php

namespace app\models;

use Yii;
<<<<<<< HEAD
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%disciplina}}".
=======

/**
 * This is the model class for table "disciplina".
>>>>>>> origin/G2-Torneos
 *
 * @property int $id
 * @property string $nombre
 * @property string|null $descripcion
 *
<<<<<<< HEAD
 * @property Pista[] $pista
=======
>>>>>>> origin/G2-Torneos
 * @property Torneo[] $torneos
 */
class Disciplina extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
<<<<<<< HEAD
        return '{{%disciplina}}';
=======
        return 'disciplina';
>>>>>>> origin/G2-Torneos
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 100],
            [['descripcion'], 'string', 'max' => 1000],
            [['nombre'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
<<<<<<< HEAD
            'id' => Yii::t('app', 'ID'),
            'nombre' => Yii::t('app', 'Nombre'),
            'descripcion' => Yii::t('app', 'Descripcion'),
=======
            'id' => 'ID',
            'nombre' => 'Nombre',
            'descripcion' => 'Descripcion',
>>>>>>> origin/G2-Torneos
        ];
    }

    /**
<<<<<<< HEAD
     * Gets query for [[Pista]].
     *
     * @return \yii\db\ActiveQuery|PistaQuery
     */
    public function getPista()
    {
        return $this->hasMany(Pista::class, ['disciplina_id' => 'id']);
    }

    /**
=======
>>>>>>> origin/G2-Torneos
     * Gets query for [[Torneos]].
     *
     * @return \yii\db\ActiveQuery|TorneoQuery
     */
<<<<<<< HEAD
    /*public function getTorneos()
    {
        return $this->hasMany(Torneo::class, ['disciplina_id' => 'id']);
    }*/
=======
    public function getTorneos()
    {
        return $this->hasMany(Torneo::class, ['disciplina_id' => 'id']);
    }
>>>>>>> origin/G2-Torneos

    /**
     * {@inheritdoc}
     * @return DisciplinaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DisciplinaQuery(get_called_class());
    }
<<<<<<< HEAD

    public static function getListadoDisciplinas()
    {
        return ArrayHelper::map(Disciplina::find()->all(), 'id', 'nombre');
    }
=======
>>>>>>> origin/G2-Torneos
}

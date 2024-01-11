<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "torneo_equipo".
 *
 * @property int $torneo_id
 * @property int $equipo_id
 *
 * @property Equipo $equipo
 * @property Torneo $torneo
 */
class TorneoEquipo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'torneo_equipo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['torneo_id', 'equipo_id'], 'required'],
            [['torneo_id', 'equipo_id'], 'integer'],
            [['torneo_id', 'equipo_id'], 'unique', 'targetAttribute' => ['torneo_id', 'equipo_id']],
            [['torneo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Torneo::class, 'targetAttribute' => ['torneo_id' => 'id']],
            [['equipo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Equipo::class, 'targetAttribute' => ['equipo_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'torneo_id' => Yii::t('app', 'Torneo ID'),
            'equipo_id' => Yii::t('app', 'Equipo ID'),
        ];
    }

    /**
     * Gets query for [[Equipo]].
     *
     * @return \yii\db\ActiveQuery|EquipoQuery
     */
    public function getEquipo()
    {
        return $this->hasOne(Equipo::class, ['id' => 'equipo_id']);
    }

    /**
     * Gets query for [[Torneo]].
     *
     * @return \yii\db\ActiveQuery|TorneoQuery
     */
    public function getTorneo()
    {
        return $this->hasOne(Torneo::class, ['id' => 'torneo_id']);
    }

    /**
     * {@inheritdoc}
     * @return TorneoEquipoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TorneoEquipoQuery(get_called_class());
    }
}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "equipo_participante".
 *
 * @property int $equipo_id
 * @property int $participante_id
 *
 * @property Equipo $equipo
 * @property Participante $participante
 */
class EquipoParticipante extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'equipo_participante';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['equipo_id', 'participante_id'], 'required'],
            [['equipo_id', 'participante_id'], 'integer'],
            [['equipo_id', 'participante_id'], 'unique', 'targetAttribute' => ['equipo_id', 'participante_id']],
            [['equipo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Equipo::class, 'targetAttribute' => ['equipo_id' => 'id']],
            [['participante_id'], 'exist', 'skipOnError' => true, 'targetClass' => Participante::class, 'targetAttribute' => ['participante_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'equipo_id' => Yii::t('app', 'Equipo ID'),
            'participante_id' => Yii::t('app', 'Participante ID'),
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
     * Gets query for [[Participante]].
     *
     * @return \yii\db\ActiveQuery|ParticipanteQuery
     */
    public function getParticipante()
    {
        return $this->hasOne(Participante::class, ['id' => 'participante_id']);
    }

    /**
     * {@inheritdoc}
     * @return EquipoParticipanteQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EquipoParticipanteQuery(get_called_class());
    }
}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reserva_pista".
 *
 * @property int $reserva_id
 * @property int $pista_id
 *
 * @property Pista $pista
 * @property Reserva $reserva
 */
class ReservaPista extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reserva_pista';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reserva_id', 'pista_id'], 'required'],
            [['reserva_id', 'pista_id'], 'integer'],
            [['reserva_id', 'pista_id'], 'unique', 'targetAttribute' => ['reserva_id', 'pista_id']],
            [['reserva_id'], 'exist', 'skipOnError' => true, 'targetClass' => Reserva::class, 'targetAttribute' => ['reserva_id' => 'id']],
            [['pista_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pista::class, 'targetAttribute' => ['pista_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'reserva_id' => 'Reserva ID',
            'pista_id' => 'Pista ID',
        ];
    }

    /**
     * Gets query for [[Pista]].
     *
     * @return \yii\db\ActiveQuery|PistaQuery
     */
    public function getPista()
    {
        return $this->hasOne(Pista::class, ['id' => 'pista_id']);
    }

    /**
     * Gets query for [[Reserva]].
     *
     * @return \yii\db\ActiveQuery|ReservaQuery
     */
    public function getReserva()
    {
        return $this->hasOne(Reserva::class, ['id' => 'reserva_id']);
    }

    /**
     * {@inheritdoc}
     * @return ReservaPistaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ReservaPistaQuery(get_called_class());
    }
}

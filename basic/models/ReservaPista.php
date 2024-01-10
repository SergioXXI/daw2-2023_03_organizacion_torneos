<?php

namespace app\models;

use Yii;

/**
<<<<<<< HEAD
 * This is the model class for table "{{%reserva_pista}}".
=======
 * This is the model class for table "reserva_pista".
>>>>>>> origin/G2-Torneos
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
<<<<<<< HEAD
        return '{{%reserva_pista}}';
=======
        return 'reserva_pista';
>>>>>>> origin/G2-Torneos
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
<<<<<<< HEAD
            [['pista_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pistum::class, 'targetAttribute' => ['pista_id' => 'id']],
=======
            [['pista_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pista::class, 'targetAttribute' => ['pista_id' => 'id']],
>>>>>>> origin/G2-Torneos
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
<<<<<<< HEAD
            'reserva_id' => Yii::t('app', 'Reserva ID'),
            'pista_id' => Yii::t('app', 'Pista ID'),
=======
            'reserva_id' => 'Reserva ID',
            'pista_id' => 'Pista ID',
>>>>>>> origin/G2-Torneos
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

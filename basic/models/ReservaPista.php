<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%reserva_pista}}".
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
        return '{{%reserva_pista}}';
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
            'reserva_id' => Yii::t('app', 'Reserva ID'),
            'pista_id' => Yii::t('app', 'Pista ID'),
            'pistaNombre' => Yii::t('app', 'Pista'),
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

    //Función que obtiene el objeto pista asociado a la reserva_pista llamando a la función getPista y posteriormente devuelve una string
    //con el valor del campo nombre de la tabla pista
    public function getPistaNombre()
    {
        $pista = $this->pista;
        if($pista !== null)
            return $pista->nombre; //Acceso al parametro nombre de pista
        return null;
    }

    //Función que obtiene el objeto reserva asociado a la reserva_pista llamando a la función getReserva y posteriormente devuelve una string
    //con el valor del campo fecha de la tabla reserva
    public function getReservaFecha()
    {
        $reserva = $this->reserva;
        if($reserva !== null)
            return $reserva->fecha; //Acceso al parametro fecha de reserva
        return null;
    }
}

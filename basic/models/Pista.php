<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pista".
 *
 * @property int $id
 * @property string $nombre
 * @property string|null $descripcion
 * @property int $direccion_id
 *
 * @property Direccion $direccion
 * @property ReservaPista[] $reservaPistas
 * @property Reserva[] $reservas
 */
class Pista extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pista';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'direccion_id'], 'required'],
            [['direccion_id'], 'integer'],
            [['nombre', 'descripcion'], 'string', 'max' => 100],
            [['nombre'], 'unique'],
            [['direccion_id'], 'exist', 'skipOnError' => true, 'targetClass' => Direccion::class, 'targetAttribute' => ['direccion_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'descripcion' => 'Descripcion',
            'direccion_id' => 'Direccion ID',
        ];
    }

    /**
     * Gets query for [[Direccion]].
     *
     * @return \yii\db\ActiveQuery|DireccionQuery
     */
    public function getDireccion()
    {
        return $this->hasOne(Direccion::class, ['id' => 'direccion_id']);
    }

    /**
     * Gets query for [[ReservaPistas]].
     *
     * @return \yii\db\ActiveQuery|ReservaPistaQuery
     */
    public function getReservaPistas()
    {
        return $this->hasMany(ReservaPista::class, ['pista_id' => 'id']);
    }

    /**
     * Gets query for [[Reservas]].
     *
     * @return \yii\db\ActiveQuery|ReservaQuery
     */
    public function getReservas()
    {
        return $this->hasMany(Reserva::class, ['id' => 'reserva_id'])->viaTable('reserva_pista', ['pista_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return PistaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PistaQuery(get_called_class());
    }
}

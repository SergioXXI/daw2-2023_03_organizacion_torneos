<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reserva_material".
 *
 * @property int $reserva_id
 * @property int $material_id
 *
 * @property Material $material
 * @property Reserva $reserva
 */
class ReservaMaterial extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reserva_material';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reserva_id', 'material_id'], 'required'],
            [['reserva_id', 'material_id'], 'integer'],
            [['reserva_id', 'material_id'], 'unique', 'targetAttribute' => ['reserva_id', 'material_id']],
            [['reserva_id'], 'exist', 'skipOnError' => true, 'targetClass' => Reserva::class, 'targetAttribute' => ['reserva_id' => 'id']],
            [['material_id'], 'exist', 'skipOnError' => true, 'targetClass' => Material::class, 'targetAttribute' => ['material_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'reserva_id' => 'Reserva ID',
            'material_id' => 'Material ID',
        ];
    }

    /**
     * Gets query for [[Material]].
     *
     * @return \yii\db\ActiveQuery|MaterialQuery
     */
    public function getMaterial()
    {
        return $this->hasOne(Material::class, ['id' => 'material_id']);
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
     * @return ReservaMaterialQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ReservaMaterialQuery(get_called_class());
    }
}

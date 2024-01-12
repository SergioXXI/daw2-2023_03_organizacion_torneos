<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "material".
 *
 * @property int $id
 * @property string $nombre
 * @property string $color
 * @property string|null $descripcion
 *
 * @property ReservaMaterial[] $reservaMaterials
 * @property Reserva[] $reservas
 */
class Material extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'material';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'color'], 'required'],
            [['nombre'], 'string', 'max' => 100],
            [['color'], 'string', 'max' => 20],
            [['descripcion'], 'string', 'max' => 500],
            [['nombre'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'nombre' => Yii::t('app', 'Nombre'),
            'color' => Yii::t('app', 'Color'),
            'descripcion' => Yii::t('app', 'Descripcion'),
        ];
    }

    /**
     * Gets query for [[ReservaMaterials]].
     *
     * @return \yii\db\ActiveQuery|ReservaMaterialQuery
     */
    public function getReservaMaterials()
    {
        return $this->hasMany(ReservaMaterial::class, ['material_id' => 'id']);
    }

    /**
     * Gets query for [[Reservas]].
     *
     * @return \yii\db\ActiveQuery|ReservaQuery
     */
    public function getReservas()
    {
        return $this->hasMany(Reserva::class, ['id' => 'reserva_id'])->viaTable('reserva_material', ['material_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return MaterialQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MaterialQuery(get_called_class());
    }
}

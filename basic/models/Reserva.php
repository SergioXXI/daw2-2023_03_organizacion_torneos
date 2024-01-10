<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%reserva}}".
 *
 * @property int $id
 * @property string $fecha
 * @property int $usuario_id
 *
 * @property Material[] $materials
 * @property Pista[] $pistas
 * @property ReservaMaterial[] $reservaMaterials
 * @property ReservaPista[] $reservaPista
 * @property Usuario $usuario
 */
class Reserva extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%reserva}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha', 'usuario_id'], 'required'],
            [['fecha'], 'safe'],
            [['usuario_id'], 'integer'],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::class, 'targetAttribute' => ['usuario_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'fecha' => Yii::t('app', 'Fecha'),
            'usuario_id' => Yii::t('app', 'Usuario ID'),
        ];
    }

    /**
     * Gets query for [[Materials]].
     *
     * @return \yii\db\ActiveQuery|MaterialQuery
     */
    public function getMaterials()
    {
        return $this->hasMany(Material::class, ['id' => 'material_id'])->viaTable('reserva_material', ['reserva_id' => 'id']);
    }

    /**
     * Gets query for [[Pistas]].
     *
     * @return \yii\db\ActiveQuery|PistaQuery
     */
    public function getPistas()
    {
        return $this->hasMany(Pista::class, ['id' => 'pista_id'])->viaTable('{{%reserva_pista}}', ['reserva_id' => 'id']);
    }

    /**
     * Gets query for [[ReservaMaterials]].
     *
     * @return \yii\db\ActiveQuery|ReservaMaterialQuery
     */
    public function getReservaMaterials()
    {
        return $this->hasMany(ReservaMaterial::class, ['reserva_id' => 'id']);
    }

    /**
     * Gets query for [[ReservaPistas]].
     *
     * @return \yii\db\ActiveQuery|ReservaPistaQuery
     */
    public function getReservaPistas()
    {
        return $this->hasMany(ReservaPista::class, ['reserva_id' => 'id']);
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery|UsuarioQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuario::class, ['id' => 'usuario_id']);
    }

    /**
     * {@inheritdoc}
     * @return ReservaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ReservaQuery(get_called_class());
    }
}

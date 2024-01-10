<?php

namespace app\models;

use Yii;

/**
<<<<<<< HEAD
 * This is the model class for table "{{%reserva}}".
=======
 * This is the model class for table "reserva".
>>>>>>> origin/G2-Torneos
 *
 * @property int $id
 * @property string $fecha
 * @property int $usuario_id
 *
 * @property Material[] $materials
 * @property Pista[] $pistas
 * @property ReservaMaterial[] $reservaMaterials
<<<<<<< HEAD
 * @property ReservaPista[] $reservaPista
=======
 * @property ReservaPista[] $reservaPistas
>>>>>>> origin/G2-Torneos
 * @property Usuario $usuario
 */
class Reserva extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
<<<<<<< HEAD
        return '{{%reserva}}';
=======
        return 'reserva';
>>>>>>> origin/G2-Torneos
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
<<<<<<< HEAD
            'id' => Yii::t('app', 'ID'),
            'fecha' => Yii::t('app', 'Fecha'),
            'usuario_id' => Yii::t('app', 'Usuario ID'),
=======
            'id' => 'ID',
            'fecha' => 'Fecha',
            'usuario_id' => 'Usuario ID',
>>>>>>> origin/G2-Torneos
        ];
    }

    /**
     * Gets query for [[Materials]].
     *
     * @return \yii\db\ActiveQuery|MaterialQuery
     */
<<<<<<< HEAD
    /*public function getMaterials()
    {
        return $this->hasMany(Material::class, ['id' => 'material_id'])->viaTable('{{%reserva_material}}', ['reserva_id' => 'id']);
    }*/
=======
    public function getMaterials()
    {
        return $this->hasMany(Material::class, ['id' => 'material_id'])->viaTable('reserva_material', ['reserva_id' => 'id']);
    }
>>>>>>> origin/G2-Torneos

    /**
     * Gets query for [[Pistas]].
     *
     * @return \yii\db\ActiveQuery|PistaQuery
     */
    public function getPistas()
    {
<<<<<<< HEAD
        return $this->hasMany(Pista::class, ['id' => 'pista_id'])->viaTable('{{%reserva_pista}}', ['reserva_id' => 'id']);
=======
        return $this->hasMany(Pista::class, ['id' => 'pista_id'])->viaTable('reserva_pista', ['reserva_id' => 'id']);
>>>>>>> origin/G2-Torneos
    }

    /**
     * Gets query for [[ReservaMaterials]].
     *
     * @return \yii\db\ActiveQuery|ReservaMaterialQuery
     */
<<<<<<< HEAD
    /*public function getReservaMaterials()
    {
        return $this->hasMany(ReservaMaterial::class, ['reserva_id' => 'id']);
    }*/

    /**
     * Gets query for [[ReservaPista]].
     *
     * @return \yii\db\ActiveQuery|ReservaPistumQuery
     */
    public function getReservaPista()
=======
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
>>>>>>> origin/G2-Torneos
    {
        return $this->hasMany(ReservaPista::class, ['reserva_id' => 'id']);
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery|UsuarioQuery
     */
<<<<<<< HEAD
    /*public function getUsuario()
    {
        return $this->hasOne(Usuario::class, ['id' => 'usuario_id']);
    }*/
=======
    public function getUsuario()
    {
        return $this->hasOne(Usuario::class, ['id' => 'usuario_id']);
    }
>>>>>>> origin/G2-Torneos

    /**
     * {@inheritdoc}
     * @return ReservaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ReservaQuery(get_called_class());
    }
}

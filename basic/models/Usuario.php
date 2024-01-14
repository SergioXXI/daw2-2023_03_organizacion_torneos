<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuario".
 *
 * @property int $id
 * @property string $nombre
 * @property string $apellido1
 * @property string $apellido2
 * @property string $email
 * @property string|null $rol
 * @property string $password
 *
 * @property Participante $participante
 * @property Reserva[] $reservas
 */
class Usuario extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuario';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'apellido1', 'apellido2', 'email', 'password'], 'required'],
            [['nombre', 'apellido1', 'apellido2', 'email', 'rol', 'password'], 'string', 'max' => 100],
            [['email'], 'unique'],
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
            'apellido1' => 'Apellido1',
            'apellido2' => 'Apellido2',
            'email' => 'Email',
            'rol' => 'Rol',
            'password' => 'Password',
        ];
    }

    /**
     * Gets query for [[Participante]].
     *
     * @return \yii\db\ActiveQuery|ParticipanteQuery
     */
    public function getParticipante()
    {
        return $this->hasOne(Participante::class, ['usuario_id' => 'id']);
    }

    /**
     * Gets query for [[Reservas]].
     *
     * @return \yii\db\ActiveQuery|ReservaQuery
     */
    public function getReservas()
    {
        return $this->hasMany(Reserva::class, ['usuario_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return UsuarioQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UsuarioQuery(get_called_class());
    }
}

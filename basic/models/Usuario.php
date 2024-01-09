<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%usuario}}".
 *
 * @property int $id
 * @property string $nombre
 * @property string $apellido1
 * @property string $apellido2
 * @property string $email
 * @property string $password
 * @property int|null $rol_id
 *
 * @property Participante $participante
 * @property Reserva[] $reservas
 * @property Rol $rol
 */
class Usuario extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%usuario}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'apellido1', 'apellido2', 'email', 'password'], 'required'],
            [['rol_id'], 'integer'],
            [['nombre', 'apellido1', 'apellido2', 'email', 'password'], 'string', 'max' => 100],
            [['email'], 'unique'],
            [['rol_id'], 'exist', 'skipOnError' => true, 'targetClass' => Rol::class, 'targetAttribute' => ['rol_id' => 'id']],
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
            'apellido1' => Yii::t('app', 'Apellido1'),
            'apellido2' => Yii::t('app', 'Apellido2'),
            'email' => Yii::t('app', 'Email'),
            'password' => Yii::t('app', 'Password'),
            'rol_id' => Yii::t('app', 'Rol ID'),
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
     * Gets query for [[Rol]].
     *
     * @return \yii\db\ActiveQuery|RolQuery
     */
    public function getRol()
    {
        return $this->hasOne(Rol::class, ['id' => 'rol_id']);
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

<?php

namespace app\models;
use Yii;

class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    public static function tableName()
    {
        return 'usuario';
    }

    public static function primaryKey()
    {
        return ['id'];
    }

    public function rules()
    {
        return [
            [['nombre', 'apellido1', 'apellido2', 'email'], 'required'],
            [['id'], 'integer', 'max' => PHP_INT_MAX],
            [['nombre', 'apellido1', 'apellido2', 'password'], 'string', 'max' => 100],
            [['email'], 'string', 'max' => 100],
            // password requerida cuando es guest
            [['password'], 'required', 'when' => function ($model) {
                return Yii::$app->user->isGuest;
            }, 'whenClient' => "function (attribute, value) {
                return $('#user-id').val() == '';
            }"],
            [['rol'],'safe'],
        ];
    }

    public $authKey;
    public $username;
    public $rol;

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        // Implementa la lógica para encontrar un usuario por su accessToken aquí
        return null;
    }

    public static function findByUsername($username)
    {
        return static::findOne(['email' => $username]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function validatePassword($password)
    {
        return $this->password === $password;
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
     * @return UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }
}


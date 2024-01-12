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
            ['email', 'email'],
            ['email', 'unique', 'message' => 'Este email ya está en uso.'],
            ['password', 'string'],
            ['rol', 'safe'],
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
}


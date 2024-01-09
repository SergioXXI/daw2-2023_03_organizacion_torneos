<?php

namespace app\models;
use Yii;

class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    public static function tableName()
    {
        return 'usuario';
    }

    public function rules()
    {
        return [
            [['id', 'nombre', 'apellido1', 'apellido2', 'email', 'password'], 'required'],
            [['id', 'rol_id'], 'integer', 'max' => PHP_INT_MAX],
            [['nombre', 'apellido1', 'apellido2', 'password'], 'string', 'max' => 100],
            [['email'], 'string', 'max' => 100],
            [['email'], 'unique'],
        ];
    }

    public $authKey;
    public $accessToken;
    public $username;

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

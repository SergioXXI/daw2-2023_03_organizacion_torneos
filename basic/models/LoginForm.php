<?php

namespace app\models;

use Yii;
use yii\base\Model;

class LoginForm extends Model
{
    public $email;
    public $password;

    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            ['email', 'email'],
        ];
    }

    public function login()
    {
        $user = User::findOne(['email' => $this->email]);

        if (!$user) {
            $this->addError('email', 'Email incorrecto.');
        } elseif (!$user->validatePassword($this->password)) {
            $this->addError('password', 'Contraseña incorrecta.');
        } else {
            Yii::$app->user->login($user);
            return true;
        }

        return false;
    }

}    


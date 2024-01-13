<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\IdentityInterface;

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

            // Verificar si el usuario tiene un rol asignado
            $auth = Yii::$app->authManager;
            $role = $auth->getRole('usuario'); //Asignamos el rol de usuario

            //Si el usuario que intenta iniciar sesion no tiene rol asignado (usuario que ha creado un gestor sin rol)
            //Pueda hacerlo con el mismo correo y contraseña que tenia antes
            if (!$auth->checkAccess($user->id, $role->name)) {
                // Asignar el rol al usuario
                $auth->assign($role, $user->id);
            }

            return true;
        }

        return false;
    }

}    


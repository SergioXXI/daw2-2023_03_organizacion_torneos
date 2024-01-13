<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\User;

class RegisterController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['register'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['register'],
                        'roles' => ['?', 'sysadmin', 'admin', 'gestor'], // Solo acceden admin, sysadmin, gestor y invitados
                    ],
                ],
            ],
        ];
    }

    public function actionRegister()
    {
        
        $model = new User();
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->save()) {
                // Registro exitoso
                $userId = $model->id;
                $auth = Yii::$app->authManager;

                // Cargar automáticamente los datos del formulario en el modelo
                if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                    $rol = $model->rol;

                    // Si $rol está definido y es válido, úsalo como el rol a asignar
                    if ($rol) {
                        $participanteRole = $auth->getRole($rol);

                        if ($participanteRole) {
                            $auth->assign($participanteRole, $userId);
                        }

                        // Si $rol está definido, redirige a la página de inicio
                        return $this->goHome();
                    } else {
                        // Si $rol no está definido asigna el rol 'usuario'
                        $participanteRole = $auth->getRole('usuario');

                        if ($participanteRole) {
                            $auth->assign($participanteRole, $userId);
                        }
                    }
                }

                // Redirige a la página de inicio de sesión
                return $this->redirect(['site/login']);

            } else {
                Yii::error("Error al guardar el modelo en la base de datos: " . print_r($model->errors, true));
            }
        } else {
            Yii::error("Error en la validación del modelo: " . print_r($model->errors, true));
        }

        return $this->render('register', ['model' => $model]);
    }
}

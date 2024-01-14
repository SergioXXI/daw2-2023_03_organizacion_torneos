<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\LoginForm;

class SitioController extends Controller
{
    public function actionLogin()
    {
        $model = new LoginForm(); // Utiliza el modelo LoginForm

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            // Usuario autenticado correctamente
            return $this->redirect(['site/index']);
        } 

        return $this->render('login', ['model' => $model]);
    }
}

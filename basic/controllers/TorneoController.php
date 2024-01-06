<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\torneo;

class torneos extends Controller
{
    public function actionform_torneo()
    {
         
        $model = new torneo();

        if ($model-> load(Yii::$app->request->post()) && $model-> validate()){
            $model->nombre='Pepe';
            $model->save();
            return $this->render('entry-confirm', ['model' => $model]);
        } else {
            // either the page is initially displayed or there is some validation error
            return $this->render('form_torneo', ['model' => $model]);
        }
        
    }

}
?>
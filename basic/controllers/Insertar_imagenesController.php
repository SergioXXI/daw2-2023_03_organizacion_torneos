<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Insertar_imagenes;
use yii\web\UploadedFile;
use app\models\Imagen;

class Insertar_imagenesController extends Controller
{
    public function actionUpload()
    {
        $model = new Insertar_imagenes();
        $imagen = new Imagen();

        if (Yii::$app->request->isPost) {
            $destino = '/imagenes';
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            $rutaFichero = $destino . '/' . $model->imageFile;
            if ($model->upload($destino)) {
                // file is uploaded successfully
                $imagen->ruta = $rutaFichero;
                $imagen->save();
                return;
            }
        }

        return $this->render('upload', ['model' => $model]);
    }
}
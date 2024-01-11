<?php
namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

class Insertar_imagenes extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }
    
    public function upload($destino)
    {
        if ($this->validate()) {
            $destino = \Yii::getAlias('@webroot') . '/' . $destino;
            if (!is_dir($destino)) {
                mkdir($destino, 0777, true);
            }
            $rutaFichero = $destino . '/' . $this->imageFile->baseName . '.' . $this->imageFile->extension;
            return $this->imageFile->saveAs($rutaFichero);

            /*$this->imageFile->saveAs('imagenes/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            echo "Funciona";
            return true;*/
        } else {
            return false;
        }
    }
}

?>
<?php

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

class Backup extends Model
{
    /**
     * @var UploadedFile
     */
    public $ficheroBackup;

    public function rules()
    {
        return [
            [['ficheroBackup'], 'file', 'skipOnEmpty' => false, 'extensions' => 'sql'],
        ];
    }
}
?>
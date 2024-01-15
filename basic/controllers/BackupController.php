<?php

namespace app\controllers;

use app\models\Backup;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

use Yii;

/**
 * BackupController implements the CRUD actions for Torneo model.
 */
class BackupController extends Controller
{

    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],

                //Regular acciones permitidas del controlador para los diversos usuarios
                'access' => [
                    'class' => \yii\filters\AccessControl::class,
                    'rules' => [
                        [
                            //Al no especificar acciones se aplican para todas las existentes
                            'allow' => true,
                            'roles' => ['admin', 'sysadmin'],
                        ],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Torneo models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = new Backup();
        return $this->render('index', [
            'model' => $model,
        ]);
    }


    /* Acción que permite al usuario generar un backup de la base de datos
     * La copia de seguridad creada incluye los comandos drop y create database
     *                      ***** ¡IMPORTANTE! *****
     * Para poder utilizar esta función hay que modificar el path hacia mysqldump.exe en
     * los parámetros de configuración params.php 
     */
    public function actionCrearBackup()
    {
        $db = Yii::$app->db;

        //Se obtiene la ruta a la carpeta backup
        $rutaBackup = Yii::getAlias('@app/backup/');

        $existe = true;
        //Si no existe la carpeta backup se intenta crear
        if (!file_exists($rutaBackup))
            //Se crea la carpeta y se almacena el resultado (bool)
            $existe = mkdir($rutaBackup);

        //Si la carpeta existe o se ha creado correctamente se procede al backup
        if($existe) {
            $nombreBackup = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
            $rutaFicheroBackup = $rutaBackup . '/' . $nombreBackup;

            //Separar el nombre de la base de datos del host
            //ya que en el db.php se establece asi: mysql:host=localhost;dbname=daw2_2023_03_organizacion_torneos
            $database=explode(";",$db->dsn);
            $dbname=explode("=",$database['1'])[1];
            //Obtener la ruta al ejecutable mysqldump.exe
            $mysqldump = Yii::$app->params['rutaMysqldump'];

            //Si la base de datos no dispone de contraseña se omite este parametro en el comando
            $pass = empty($db->password) ? '' : '-p{$db->password}';

            $command = "\"{$mysqldump}\" -u{$db->username} {$pass} --add-drop-database --databases {$dbname} > \"{$rutaFicheroBackup}\"";
            exec($command, $output, $returnVar);

            //Resultado de la ejecución devuelto por referencia
            if ($returnVar === 0 && file_exists($rutaFicheroBackup)) {
                Yii::$app->session->setFlash('success', 'Copia de seguridad creada correctamente en: ' . $rutaBackup . '.');
            } else {
                Yii::$app->session->setFlash('error', 'Fallo al crear la copia de seguridad.');
            }
        } else {
            Yii::$app->session->setFlash('error', 'No se ha encontrado la carpeta ' . $rutaBackup . ' y ha fallado la creación de la misma.');
        }

        return $this->redirect(['index']);
    }

    /* Acción que permite al usuario restaurar una copia de la base de datos
     * Esta copia de seguridad debe ser un fichero .sql
     *                      ***** ¡IMPORTANTE! *****
     * Para poder utilizar esta función hay que modificar el path hacia mysql.exe en
     * los parámetros de configuración params.php 
     */
    public function actionRestaurarBackup()
    {
        $model = new Backup();
        $db = Yii::$app->db;

        if (Yii::$app->request->isPost) {
            //Obtener una instacia del fichero subido por el usuario
            $model->ficheroBackup = UploadedFile::getInstance($model, 'ficheroBackup');
            //Obtener la ruta temporal del fichero
            $rutaFicheroBackup = $model->ficheroBackup->tempName; 

            //Separar el nombre de la base de datos del host
            //ya que en el db.php se establece asi: mysql:host=localhost;dbname=daw2_2023_03_organizacion_torneos
            $database=explode(";",$db->dsn);
            $dbname=explode("=",$database['1'])[1];
            //Obtener la ruta al ejecutable mysql.exe
            $mysql = Yii::$app->params['rutaMysql'];

            //Si la base de datos no dispone de contraseña se omite este parametro en el comando
            $pass = empty($db->password) ? '' : '-p{$db->password}';

            $command = "\"{$mysql}\" -u{$db->username} {$pass} {$dbname} < \"{$rutaFicheroBackup}\"";
            exec($command, $output, $returnValue);

            //Resultado de la ejecución devuelto por referencia
            if ($returnValue === 0) {
                Yii::$app->session->setFlash('success', 'Copiar de seguridad restaurada correctamente.');
            } else {
                Yii::$app->session->setFlash('error', 'Fallo al restaurar la copia de seguridad.');
            }
            
        }
        return $this->render('index');
    }

}

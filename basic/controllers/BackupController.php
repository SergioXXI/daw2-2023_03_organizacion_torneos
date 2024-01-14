<?php

namespace app\controllers;

use app\models\Backup;
use yii\web\Controller;
use yii\filters\VerbFilter;

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


    public function actionCrearBackup()
    {
        $db = \Yii::$app->db;

        $rutaBackup = \Yii::getAlias('@app/backup/');

        if (file_exists($rutaBackup)) {
            $nombreBackup = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
            $rutaFicheroBackup = $rutaBackup . '/' . $nombreBackup;

            $database=explode(";",$db->dsn);
            $dbname=explode("=",$database['1'])[1];
            $mysql = \Yii::$app->params['rutaMysqldump'];

            $command = "\"{$mysql}\" -u{$db->username} -B {$dbname} > \"{$rutaFicheroBackup}\"";

            exec($command, $output, $returnVar);

            if ($returnVar === 0 && file_exists($rutaFicheroBackup)) {
                \Yii::$app->session->setFlash('success', 'Copia de seguridad creada correctamente en: ' . $rutaBackup . '.');
            } else {
                \Yii::$app->session->setFlash('error', 'Fallo al crear la copia de seguridad.');
            }
        }


        return $this->redirect(['index']);
    }

}

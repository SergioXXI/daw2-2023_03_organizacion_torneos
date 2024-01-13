<?php

namespace app\controllers;

use app\models\Participante;
use app\models\ParticipanteSearch;
use app\models\TipoParticipante;
use app\models\Usuario;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * ParticipanteController implements the CRUD actions for Participante model.
 */
class ParticipanteController extends Controller
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
            ]
        );
    }

    /**
     * Lists all Participante models.
     *
     * @return string
     */
    public function actionIndex()
    {

        $searchModel = new ParticipanteSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Participante model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Participante model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Participante();
        $usuarioModel = new Usuario();
        $userType = \Yii::$app->request->post('userType', null);

        // Obtener todos los tipos de participantes
        $tiposParticipantes = TipoParticipante::find()->all();
        $listaTiposParticipantes = ArrayHelper::map($tiposParticipantes, 'id', 'nombre');

        // Convertir a un array para el desplegable
        $listaTiposParticipantes = ArrayHelper::map($tiposParticipantes, 'id', 'nombre');    

          // Obtener usuarios que no están vinculados a un participante
        $usuarios = Usuario::find()->leftJoin('participante', 'usuario.id = participante.usuario_id')
            ->where(['participante.usuario_id' => null])
            ->all();
        $listaUsuarios = ArrayHelper::map($usuarios, 'id', 'nombre'); // Ajusta 'nombre' según tu modelo Usuario

        if ($this->request->isPost) {
             // Cargar datos en el modelo Participante
            $model->load($this->request->post());
            // Verificar si se seleccionó un usuario existente
            if (!empty($this->request->post('Participante')['usuario_id'])) {
                // Participante vinculado a un usuario existente
                
                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } else {
                $usuarioModel->load($this->request->post());
                // Creación de un nuevo usuario y participante
                if ($usuarioModel->save()) {
                    $model->usuario_id = $usuarioModel->id;
                    if ($model->save()) {
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
            'listaTiposParticipantes' => $listaTiposParticipantes,
            'listaUsuarios' => $listaUsuarios,
            'usuarioModel' => $usuarioModel,
            'userType' => $userType,
        ]);
    }

    /**
     * Updates an existing Participante model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $usuarioModel = Usuario::findOne($model->usuario_id);

        // Obtener todos los tipos de participantes
        $tiposParticipantes = TipoParticipante::find()->all();
        $listaTiposParticipantes = ArrayHelper::map($tiposParticipantes, 'id', 'nombre');

        // Convertir a un array para el desplegable
        $listaTiposParticipantes = ArrayHelper::map($tiposParticipantes, 'id', 'nombre');    

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save() && $usuarioModel->load($this->request->post()) && $usuarioModel->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'listaTiposParticipantes' => $listaTiposParticipantes,
            'usuarioModel' => $usuarioModel,
        ]);
    }

    /**
     * Deletes an existing Participante model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Participante model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Participante the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Participante::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}

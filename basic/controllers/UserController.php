<?php

namespace app\controllers;

use app\models\User;
use app\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
                'access' => [
                    'class' => \yii\filters\AccessControl::class,
                    'rules' => [
                        [
                            'allow' => true,
                            'actions' => ['register'],
                            'roles' => ['?', 'sysadmin', 'admin', 'gestor'], // Solo acceden admin, sysadmin, gestor y invitados
                        ],
                        [
                            'actions' => ['view-profile', 'self-update'],
                            'allow' => true,
                            'roles' => ['sysadmin', 'admin', 'organizador', 'gestor', 'usuario'],
                        ],
                        [
                            'actions' => ['index', 'view', 'create', 'delete', 'update'],
                            'allow' => true,
                            'roles' => ['sysadmin', 'admin']
                        ],
                    ],
                ],
            ]
        );
    }
    
    /**
     * Displays the user registration form.
     * 
     * @return string|\yii\web\Response
     */
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

    /**
     * Lists all User models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        // Paginacion
        $perPage = $this->request->get('per-page');
        if ($perPage !== null && $perPage >= Yii::$app->params['minUserPerPage'] && $perPage <= Yii::$app->params['maxUserPerPage']) {
            $dataProvider->pagination->pageSize = $perPage;
        } else {
            $dataProvider->pagination->pageSize = Yii::$app->params['minUserPerPage'];
        }

        return $this->render('index', [
            'searchModel' => $searchModel,  
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param int $id
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
        
    }

    public function actionViewProfile()
    {
        return $this->render('view', [
            'model' => $this->findModel(Yii::$app->user->id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new User();

        if ($this->request->isPost) {
            $request = $this->request->post();
            $rolName = $request['User']['rol'];
            unset($request['User']['rol']);

            if ($model->load($request) 
                && $model->save() 
                && $this->updateRol($model->id, $rolName)) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        return $this->fullUpdate($id, false);
    }

    /**
     * Modifica el propio usuario que está realizando la petición.
     * @return string|\yii\web\Response
     */
    public function actionSelfUpdate()
    {
        return $this->fullUpdate(Yii::$app->user->id, true);
    }


    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        try{
            $this->findModel($id)->delete();
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', 'No se puede eliminar el usuario porque tiene datos asociados');
        }
        
        // try{
        //     $this->findModel($id)->delete();
        // } catch (IntegrityException $e) {
        //     throw new \yii\web\HttpException(500,"No se puede eliminar este registro ya que está siendo utilizado por otra tabla.", 405);
        // }
        
        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    /**
     * Actualiza el rol de un usuario en el sistema de control de acceso basado en roles (RBAC).
     *
     * @param int $id El ID del usuario cuyo rol se actualizará.
     * @param string|null $rol El nombre del nuevo rol a asignar al usuario. Si es null, no se realizará ninguna asignación.
     *
     * @return bool Devuelve true si la actualización del rol fue exitosa, de lo contrario, devuelve false.
     */
    protected function updateRol($id, $rol) 
    {

        if ($rol != null &&  Yii::$app->authManager->getRole($rol)) {
            Yii::$app->authManager->revokeAll($id);
            Yii::$app->authManager->assign(Yii::$app->authManager->getRole($rol), $id);
            return true; 
        } else if ($rol == null) {
            Yii::$app->authManager->revokeAll($id);
            return true;
        }
        return false;
    }
    
    /**
     * Realiza la actualización de un usuario en el sistema.
     *
     * @param int $id El ID del usuario a actualizar.
     * @param bool $propio Indica si el usuario que se va a actualizar es el propio usuario que está realizando la petición.
     *
     * @return string|\yii\web\Response
     */
    private function fullUpdate($id, $propio = false)
    {
        $model = $this->findModel($id);
        

        if ($this->request->isPost && $model->load($this->request->post()) 
            && $model->save()
            && $this->updateRol($model->id, $this->request->post('User')['rol'])) {
            return $propio 
                ? $this->redirect(['view-profile'])    
                : $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

}

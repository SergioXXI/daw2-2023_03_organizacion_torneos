<?php
namespace app\views\user;
use Yii;
Class HelperVistasUser  
{
    /**
     * Extrae los roles para el desplegable
     * 
     * @return array|null
     */
    static protected function extraerRolesDesplegableGenerico() {
        $roles = null;
        if (Yii::$app->user->can('sysadmin')) {
            // Obtenemos los roles hijos del rol asignado al usuario
            $roles = Yii::$app->authManager->getChildRoles('sysadmin');
            // para que el usuario que si el usuario a modificar es sysadmin
            // pueda no quitarse el rol sysadmin
            if (Yii::$app->user->id != Yii::$app->request->get('id')) {
                unset($roles['sysadmin']);
            }

        } else if (Yii::$app->user->can('admin')) {
            $roles = Yii::$app->authManager->getChildRoles('admin');
            if (Yii::$app->user->id != Yii::$app->request->get('id')) {
                unset($roles['admin']);
            }
        } else if (Yii::$app->user->can('gestor')) {
            $roles[] = Yii::$app->authManager->getRole('usuario');
        } else {
            return null;
        }
        return $roles;
    }

    /**
     * Extrae los roles para el desplegable con Jugador sin Registrar
     * 
     * @return array|null
     */
    static public function extraerRolesDesplegableConInvitado() {
        $roles[] = HelperVistasUser::extraerRolesDesplegableGenerico();
        if ($roles == null) {
            return null;
        }
        // no existe ese rol asi que es meramente visual
        array_push($roles, 'Jugador sin Registrar');
        return $roles;
    }

    /**
     * Extrae los roles para el desplegable con un campo vacio
     * 
     * @return array|null
     */
    static public function extraerRolesDesplegableConVacio() {
        
        $roles = HelperVistasUser::extraerRolesDesplegableGenerico();
        if ($roles == null) {
            return null;
        }
        array_push($roles, '');
        return $roles;
    }

}
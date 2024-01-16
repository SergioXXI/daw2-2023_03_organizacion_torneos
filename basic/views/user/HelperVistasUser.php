<?php
namespace app\views\user;
use Yii;
Class HelperVistasUser  
{
    /**
     * Extrae los roles para el desplegable y añade uno pasado como parametro
     * 
     * @return array|null
     */
    static public function extraerRolesDesplegable() {
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
        } else {
            return null;
        }


        return $roles;
    }
}
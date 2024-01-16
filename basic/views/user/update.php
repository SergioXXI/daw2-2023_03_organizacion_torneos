<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\User $model */

$this->title = Yii::t('app', 'Modificar usuario: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');

// si el id del usuario que queremos modificar coincide con el id del usuario logueado y es sysadmin
// en $roles solo tiene que aparecer sysadmin
$rolesUsuario = Yii::$app->authManager->getRolesByUser(Yii::$app->request->get('id'));
// Se supone que cada usuario solo tiene un rol
$rolUsuario = !empty($rolesUsuario) ? reset($rolesUsuario) : null;

if (Yii::$app->user->id == Yii::$app->request->get('id') 
    && (Yii::$app->user->can('sysadmin') || Yii::$app->user->can('admin'))
    // admin no puede modificar el rol a sysadmin
    || (Yii::$app->user->can('admin') && $rolUsuario->name == 'sysadmin')
    ) {
    $roles = null;
} else {
    $roles = app\views\user\HelperVistasUser::extraerRolesDesplegable(); // Extraemos los roles para el desplegable
}
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'roles' => $roles,
    ]) ?>

</div>

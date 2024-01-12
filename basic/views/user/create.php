<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\User $model */

$this->title = Yii::t('app', 'Crear usuario');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$roles = null;
if (Yii::$app->user->can('sysadmin')) {
    // Obtenemos los roles hijos del rol asignado al usuario
    $roles = Yii::$app->authManager->getChildRoles('sysadmin');
    array_push($roles, '');
} else if (Yii::$app->user->can('admin')) {
    $roles = Yii::$app->authManager->getChildRoles('admin');
    array_push($roles, '');
}
?>
<div class="user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'roles' => $roles,
    ]) ?>

</div>

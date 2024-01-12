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
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'roles' => $roles,
    ]) ?>

</div>

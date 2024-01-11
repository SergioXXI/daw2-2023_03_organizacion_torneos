<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\User $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$attributes = [
    'nombre',
    'apellido1',
    'apellido2',
    'email:email',
    // 'password',
];

// si es admin le metemos los atributos que queramos
if (Yii::$app->user->can('admin') || Yii::$app->user->can('sysadmin')) {
    // Añadimos id y rol
    array_push($attributes, 'id', [
        'attribute' => 'roles',
        'label' => Yii::t('app', 'Rol'),
        'value' => function ($model) {
            $roles = Yii::$app->authManager->getRolesByUser($model->id);
            return implode(', ', array_keys($roles));
        },
    ]); 
}
?>
<div class="user-view">

    <h1><?= Html::encode($model->nombre . ' ' . $model->apellido1) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Actualizar'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Borrar'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', '¿Seguro que quieres borrar este usuario?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => $attributes,
    ]) ?>

</div>

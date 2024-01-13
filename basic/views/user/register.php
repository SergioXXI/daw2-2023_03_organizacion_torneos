<?php
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\User $model */

$this->title = 'Registro';
$this->params['breadcrumbs'][] = $this->title;

$roles = app\views\user\HelperVistasUser::extraerRolesDesplegable('Jugador sin Registrar'); // Extraemos los roles para el desplegable
?>
<div class="site-register">

<h1><?= Html::encode($this->title) ?></h1>

<?= $this->render('_form', [
    'model' => $model,
    'roles' => $roles,
]) ?>

</div>
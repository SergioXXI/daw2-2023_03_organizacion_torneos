
<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Equipo $model */

$this->title = Yii::t('app', 'Crear Equipo');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Equipos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="equipo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'listaCategorias' => $listaCategorias,
        'listaParticipantes' => $listaParticipantes,
    ]) ?>

</div>

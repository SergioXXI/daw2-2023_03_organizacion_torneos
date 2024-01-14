<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Premio $model */

$this->title = Yii::t('app', 'Create Premio');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Premios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="premio-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

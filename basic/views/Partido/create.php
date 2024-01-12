<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Partido $model */

$this->title = Yii::t('app', 'Create Partido');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Partidos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="partido-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        
    ]) ?>

</div>

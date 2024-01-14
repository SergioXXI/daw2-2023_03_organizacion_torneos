<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Normativa $model */

$this->title = Yii::t('app', 'Create Normativa');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Normativas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="normativa-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

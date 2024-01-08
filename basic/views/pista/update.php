<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Pista $model */

$this->title = Yii::t('app', 'Update Pista: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pistas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="pista-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <pre>
    <?php print_r($model); ?>
    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

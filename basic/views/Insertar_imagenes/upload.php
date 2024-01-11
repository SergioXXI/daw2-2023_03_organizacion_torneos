<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Insertar_imagenes $model */

$this->title = 'Insertar imagen';
?>
<div class="">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

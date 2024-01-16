<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model string */

?>

<tr class="backup-item my-2">
    <td><?= Html::encode(basename($model)) ?></td>
    <td><?= Html::encode(date ("Y-m-d H:i:s.", filemtime($model))) ?></td> <!-- Fecha de última modificación del fichero con filemtime -->
    <td class="text-center"><?= Html::a('Restaurar', ['restaurar-fichero'], ['class' => 'btn btn-primary', 'data' => [
        'method' => 'post', 'params' => ['fichero' => basename($model),]
        ]]); ?></td>
</tr>
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;


//Para que funcione correctamente la activación y desactivación de la paginación se ha eliminado el Pjax

$this->title = Yii::t('app', 'Backups');

$icon = '<div class="input-group">{input}' . Html::submitButton('Restaurar Backup', ['class' => 'btn btn-warning']) . '</div>{error}';
?>

<div class="log-index">


    <?php $form = ActiveForm::begin(['action' => ['restaurar-subido'], 'options' => ['enctype' => 'multipart/form-data']]); ?>

    <h1 class='mb-4'><?= Html::encode($this->title) ?></h1>

    <div class="d-flex gap-3 align-items-center mb-2">
        <?= Html::a('Crear Backup',['crear-backup'], ['class' => 'btn btn-success']) ?>
        <?= $form->field($model, 'ficheroBackup', ['template' => $icon, 'options' => ['class' => 'mb-0']])->fileInput(['label' => false, 'class' => 'form-control mb-0']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <!-- Mostrar los ficheros contenidos en la carpeta backups en formato tabla -->
    <div class="mt-3">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th scope="col">Fichero</th>
                    <th scope="col">Fecha de última modificación</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php echo ListView::widget([
                    'dataProvider' => $ficherosBackup,
                    'itemView' => '_fichero', //Renderizar la vista que _fichero que muestra un fichero en una fila de la tabla
                    'summary' => 'Mostrando ' . Html::tag('b', '{begin}-{end}') . ' de ' .  Html::tag('b', '{totalCount}') . ' elementos', //Para cambiar el idioma del texto del summary
                    'emptyText' => 'No hay resultados',
                ]); ?>
            </tbody>
        </table>
    </div>
    
</div>



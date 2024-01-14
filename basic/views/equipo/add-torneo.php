<?php
use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Equipo $equipo */
/** @var app\models\Torneo $torneoModel */
/** @var array $listaTorneos */

$this->title = 'Unirse a un Torneo';
$this->params['breadcrumbs'][] = ['label' => 'Equipos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="equipo-join-torneo">
    <h1><?= Html::encode($this->title) 
    ?></h1>
    

    <?= GridView::widget([
        'dataProvider' => $listaTorneos, // Asegúrate de que esto es un DataProvider
        'columns' => [
            // Columnas con la información del torneo
            'nombre',
            // ...
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{unirse}',
                'buttons' => [
                    'unirse' => function ($url, $model, $key) use ($equipo) {
                        return Html::a('Unirse', Url::to(['add-torneo', 'id' => $equipo->id, 'torneoId' => $model['id']]), [
                            'class' => 'btn btn-success',
                        ]);
                    },
                ],
            ],
        ],
    ]) ?>
</div>
<?php
use yii\widgets\ActiveForm;
use yii\data\ActiveDataProvider;
use app\models\Material;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\MaterialSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var app\models\Material $model */
$id_reserva = $id_reserva ?? null;



$this->title = 'Reservas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reserva-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
<?php 

    $dataProvider = new ActiveDataProvider([
        'query' => Material::find()
            ->where(['not exists',
                (new \yii\db\Query())
                    ->select('*')
                    ->from('reserva_material')
                    ->where('reserva_material.material_id = material.id')
                    ->andWhere(['reserva_material.reserva_id' => $id_reserva])
            ]),
    ]);

    ?>
    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'nombre',
            'color',
            'descripcion',
            [
                
                'class' => 'yii\grid\ActionColumn',
                'template' => '{custom}', // Agregamos el nuevo botón 'custom'
                'buttons' => [
                'custom' => function ($url, $model, $key)use ($id_reserva) {
                    return Html::a(
                        'TuTextoDelBoton', // Texto del botón
                        ['materiales_reservas2', 'id' => $model->id,'id_reserva'=>$id_reserva], // URL a la que apunta el botón
                        [
                            'class' => 'btn btn-primary', // Clase CSS del botón
                            'data' => [
                                'confirm' => '¿Estás seguro de que quieres realizar esta acción?', // Mensaje de confirmación
                                'method' => 'post', // Método HTTP
                            ],
                        ]
                    );
                },
            ],
            ],
        
            
        ],
    ]); ?>
    


</div>

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
                    ->andWhere(['reserva_material.reserva_id' => 1])
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
                
                'attribute' => 'id',
                'format' => 'raw',
                'value' => function ($model) {
                
                $form = ActiveForm::begin(); 
                echo Html::submitButton('', ['class' => 'btn btn-success']) ;
                ActiveForm::end();
                  
                },

                 
            ],
        ],
    ]); ?>
    


</div>

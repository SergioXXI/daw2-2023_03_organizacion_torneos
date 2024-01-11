Para la accion del controlador correspondiente, cambiar lo de $model->reservas por la tabla que se quiera
Es una llamada a un metodo que se genero automaticamente al crearse el controlador y permite obtener datos de tablas donde
existe una clave foranea asociada

```
public function actionView($id)
    {
        $model = $this->findModel($id);

        $pistasProvider = new ArrayDataProvider([
            'allModels' => $model->reservas,
            'sort' => [
                'attributes' => ['id', 'fecha'],
            ],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('view', [
            'model' => $model,
            'reservasProvider' => $pistasProvider,
        ]);
}
```

Para la vista donde se muestra el modelo, es decir, fichero view.php añadir abajo lo siguiente
Cambiar la ruta y el nombre del provider si es necesario

```
<h2 class="mt-5 mb-4">Reservas asociadas</h2>

    <?= GridView::widget([
        'dataProvider' => $reservasProvider,
        'summary' => 'Mostrando ' . Html::tag('b', '{begin}-{end}') . ' de ' .  Html::tag('b', '{totalCount}') . ' elementos', //Para cambiar el idioma del texto del summary
        'emptyText' => 'No hay resultados',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            //Genera un enlace para poder ver la pista asociada a esta id
            [
                'format' => 'raw',
                'attribute' => 'id',
                'value' => function ($model) {
                    $url = Url::toRoute(['reserva/view', 'id' => $model->id]);
                    return Html::a($model->id, $url);
                },

            ],

            'fecha',
        ],
    ]); ?>
```

IMPORTANTE: ES NECESARIO IMPORTAR EL GRIDVIEW: use yii\grid\GridView;
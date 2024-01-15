<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\models\TorneoEquipo;
/** @var yii\web\View $this */
/** @var app\models\Premio $model */
/** @var yii\widgets\ActiveForm $form */

$this->title = Yii::t('app', 'Guardar ganador');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Premios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="premio-create">

    <h1><?= Html::encode($this->title) ?></h1>


<div class="premio-form">
<?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'equipo_id')->dropDownList(
    \yii\helpers\ArrayHelper::map(TorneoEquipo::find()->where(['torneo_id' => $model->torneo_id])->joinWith('equipo') // Assuming there's a relation named 'equipo'
    ->all(), 'equipo_id', 'equipo.nombre'),
    ['prompt' => 'Selecciona un equipo']
    ) ?>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Guardar ganador'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

</div>

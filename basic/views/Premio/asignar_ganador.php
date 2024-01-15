<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\models\Equipo;
/** @var yii\web\View $this */
/** @var app\models\Premio $model */
/** @var yii\widgets\ActiveForm $form */

$this->title = Yii::t('app', 'Create Premio');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Premios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="premio-create">

    <h1><?= Html::encode($this->title) ?></h1>


<div class="premio-form">
<?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'equipo_id')->dropDownList(
    \yii\helpers\ArrayHelper::map(Equipo::find()->all(), 'id', 'nombre'),
    ['prompt' => 'Selecciona un equipo']
    ) ?>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'update'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

</div>

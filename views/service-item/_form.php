<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\assets\InputMaskAsset;

/* @var $this yii\web\View */
/* @var $model app\models\ServiceItem */
/* @var $form yii\widgets\ActiveForm */
\yii\web\jQueryAsset::register($this);
InputMaskAsset::register($this);

$tax = \app\models\Tax::find()->one();
?>

<?php $form = ActiveForm::begin(); ?>

<div class="box-body">
    <?= $form->field($model, 'name')->textInput(['maxlength' => 50]) ?>
    <?= $form->field($model, 'varRate', ['template' => '{label}<div class="input-group">
            <span class="input-group-addon">'.$tax->currency.'</span>{input}</div>{hint}{error}'])
        ->textInput([
            'data-mask'=>'000.000.000.000.000',
            'data-mask-reverse'=>'true'
        ]) ?>
</div>
<div class="box-footer">
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'id'=>'btnSubmit']) ?>
</div>
<?php ActiveForm::end(); ?>
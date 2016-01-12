<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\daterange\DateRangePicker;
use kartik\datecontrol\Module;
use kartik\datecontrol\DateControl;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Discount */
/* @var $form yii\widgets\ActiveForm */
\yii\web\jQueryAsset::register($this);
\app\assets\InputMaskAsset::register($this);

$tax = \app\models\Tax::find()->one();

?>

<?php $form = ActiveForm::begin(); ?>

<div class="box-body">
    <?= $form->field($model, 'name')->textInput() ?>

    <?= $form->field($model, 'discountby')->radioList(['P' => 'Percent', 'R' => 'Rate'],['separator'=>'<span style="margin-right:20px"></span>']) ?>
    
	<?= $form->field($model, 'amount', ['template' => '{label}<div class="input-group">
        <span class="input-group-addon"><b id="addon">%</b></span>{input}</div>{hint}{error}'])
    ->textInput([
        'data-mask'=>'000.000.000.000.000.000',
        'data-mask-reverse'=>'true',
        'maxlength' => 3
    ]) ?>

	<?php
		echo $form->field($model, 'from_date')->widget(DatePicker::classname(), [
		    'options' => ['placeholder' => 'Enter start date..'],
		    'pluginOptions' => [
		        'autoclose'=>true
		    ]
		]);
	?>

	<?php
		echo $form->field($model, 'to_date')->widget(DatePicker::classname(), [
		    'options' => ['placeholder' => 'Enter end date..'],
		    'pluginOptions' => [
		        'autoclose'=>true
		    ]
		]);
	?>
</div>
<div class="box-footer">
	<?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>

<?php
	$this->registerJs('
		onChangeDiscountBy();

		function onChangeDiscountBy(){
			var valcheck = jQuery(\'input:radio[name="Discount[discountby]"]:checked\').val();
			if (valcheck == "P"){
				$("#addon").text("%");
				$("#discount-amount").attr("maxlength", 3);
			}else{
				$("#addon").text("'.$tax->currency.'");
				$("#discount-amount").attr("maxlength", 15);
			}
		}

		jQuery(\'input:radio[name="Discount[discountby]"]\').change(onChangeDiscountBy);
    ', yii\web\View::POS_READY);

?>
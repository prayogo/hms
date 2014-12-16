<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CustomerPhone */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customer-phone-form">
	<div class="form-inline" role="form">
	<?php
		if ($model->hasErrors('phone')){
			echo '<div class="form-group required has-error">';
		}else{
			echo '<div class="form-group">';
		}
	?>
	<?php
		echo Html::activeTextInput($model, '[' . $index . ']phone', [
			'maxlength' => 15, 
			'class'=>'form-control phoneinput',
			'style'=>'width:100%;min-width:500px;'
		]);
		echo Html::error($model, 'phone', ['class'=>'help-block']);
	?>
	</div>
	<a type="button" class="btnAddPhone btn btn-primary" style="vertical-align: top;"><i class="glyphicon glyphicon-plus"></i></a>
	<a type="button" class="btnDeletePhone btn btn-danger" style="vertical-align: top;"><i class="glyphicon glyphicon-minus"></i></a>
    	
    </div>
</div>

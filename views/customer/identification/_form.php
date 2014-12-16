<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\CustomerIdentification */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customer-identification-form" style="margin-bottom:10px">

	<div class="form-inline" role="form">
	<?php
		if ($model->hasErrors('identificationno')){
			echo '<div class="form-group required has-error" style="vertical-align: top;">';
		}else{
			echo '<div class="form-group" style="vertical-align: top;">';
		}
	?>
	

    <?php 

    $data = [];
    $data += yii\helpers\ArrayHelper::map(\app\models\IdentificationType::find()->asArray()->orderBy('name')->all(), 
    	'identificationtypeid', 'name');

	echo Html::activeDropDownList($model, '[' . $index . ']identificationtypeid', $data, [
		'style'=>'width:100%;min-width:150px;',
		'class'=>'identificationddl'
	]);

	?>
  	</div>

  	<?php
		if ($model->hasErrors('identificationno')){
			echo '<div class="form-group required has-error" style="vertical-align: top;">';
		}else{
			echo '<div class="form-group" style="vertical-align: top;">';
		}
	?>
    <?php
	echo Html::activeTextInput($model, '[' . $index . ']identificationno', [
		'maxlength' => 25, 
		'class'=>'form-control identificationinput',
		'style'=>'width:100%;min-width:345px;'
	]);
	?>
  	</div>

<a type="button" class="btnAddIdentification btn btn-primary" style="vertical-align: top;"><i class="glyphicon glyphicon-plus"></i></a>
<a type="button" class="btnDeleteIdentification btn btn-danger" style="vertical-align: top;"><i class="glyphicon glyphicon-minus"></i></a>   

	</div>
	<?php echo Html::error($model, 'identificationno', ['class'=>'help-block', 'style'=>'color:#a94442']);?>

</div>



<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(); ?>

<div class="box-body">
    <?= $form->field($model, 'username')->textInput(['maxlength' => 20]) ?>
    <?= $form->field($model, 'fullname')->textInput(['maxlength' => 150]) ?>
    <?= $form->field($model, 'displayname')->textInput(['maxlength' => 50]) ?>
    <?= $form->field($model, 'password')->passwordInput(['maxlength' => 150]) ?>
    <?= $form->field($model, 'varConfirmPassword')->passwordInput(['maxlength' => 150]) ?>
    <?= $form->field($model, 'phone')->textInput(['maxlength' => 15]) ?>
    <?= $form->field($model, 'email')->textInput(['maxlength' => 150]) ?>
    <?= $form->field($model, 'active')->radioList(['Y' => 'Yes', 'N' => 'No'],['separator'=>'<span style="margin-right:20px"></span>']) ?>
    <?= $form->field($model, 'admin')->radioList(['Y' => 'Yes', 'N' => 'No'],['separator'=>'<span style="margin-right:20px"></span>']) ?>
</div>
<div class="box-footer">
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>

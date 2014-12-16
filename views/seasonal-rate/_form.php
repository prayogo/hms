<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SeasonalRate */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="seasonal-rate-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 50]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => 250]) ?>

    <?= $form->field($model, 'startdate')->textInput() ?>

    <?= $form->field($model, 'enddate')->textInput() ?>

    <?= $form->field($model, 'mon')->textInput(['maxlength' => 1]) ?>

    <?= $form->field($model, 'tue')->textInput(['maxlength' => 1]) ?>

    <?= $form->field($model, 'wed')->textInput(['maxlength' => 1]) ?>

    <?= $form->field($model, 'thu')->textInput(['maxlength' => 1]) ?>

    <?= $form->field($model, 'fri')->textInput(['maxlength' => 1]) ?>

    <?= $form->field($model, 'sat')->textInput(['maxlength' => 1]) ?>

    <?= $form->field($model, 'sun')->textInput(['maxlength' => 1]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

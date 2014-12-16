<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SeasonalRateSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="seasonal-rate-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'seasonalrateid') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'description') ?>

    <?= $form->field($model, 'startdate') ?>

    <?= $form->field($model, 'enddate') ?>

    <?php // echo $form->field($model, 'mon') ?>

    <?php // echo $form->field($model, 'tue') ?>

    <?php // echo $form->field($model, 'wed') ?>

    <?php // echo $form->field($model, 'thu') ?>

    <?php // echo $form->field($model, 'fri') ?>

    <?php // echo $form->field($model, 'sat') ?>

    <?php // echo $form->field($model, 'sun') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

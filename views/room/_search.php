<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RoomSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="room-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'roomid') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'lockid') ?>

    <?= $form->field($model, 'description') ?>

    <?= $form->field($model, 'floorid') ?>

    <?php // echo $form->field($model, 'roomtypeid') ?>

    <?php // echo $form->field($model, 'roomstatusid') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

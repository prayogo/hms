<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RoomTypeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="room-type-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'roomtypeid') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'singleb') ?>

    <?= $form->field($model, 'doubleb') ?>

    <?= $form->field($model, 'extrab') ?>

    <?php // echo $form->field($model, 'maxchild') ?>

    <?php // echo $form->field($model, 'maxadult') ?>

    <?php // echo $form->field($model, 'childcharge') ?>

    <?php // echo $form->field($model, 'adultcharge') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'rate') ?>

    <?php // echo $form->field($model, 'weekendrate') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

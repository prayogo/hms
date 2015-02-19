<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Discount */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="discount-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php    	
    	$sql = "select roomtypeid, name from ps_roomtype";  
        $data = [];
        $data += yii\helpers\ArrayHelper::map(\app\models\RoomReservation::findBySql($sql)
            ->asArray()
            ->all(), 'roomtypeid', 'name');

        echo $form->field($model, 'roomtypeid')->widget(Select2::classname(), [
            'data' => $data,
            'options' => ['placeholder' => 'Select a room type ...'],
            'pluginOptions' => [
            ],
        ]);

    ?>

    <?= $form->field($model, 'startdate')->textInput() ?>

    <?= $form->field($model, 'enddate')->textInput() ?>

    <?= $form->field($model, 'discountrate')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

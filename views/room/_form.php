<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Room */
/* @var $form yii\widgets\ActiveForm */

?>

<?php $form = ActiveForm::begin(); ?>

<div class="box-body">
    <?= $form->field($model, 'name')->textInput(['maxlength' => 50]) ?>
    <?= $form->field($model, 'lockid')->textInput(['maxlength' => 50]) ?>
    <?= $form->field($model, 'description')->textArea(['maxlength' => 250, 'style'=>'height:120px']) ?>

    <?php 
        $data = [];
        $data += yii\helpers\ArrayHelper::map(\app\models\Floor::find()->asArray()->orderBy('name')->all(), 'floorid', 'name');

        echo $form->field($model, 'floorid')->widget(Select2::classname(), [
            'data' =>$data,
            'options' => ['placeholder' => 'Select a floor ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
    ?>

    <?php 
        $data = [];
        $data += yii\helpers\ArrayHelper::map(\app\models\RoomType::find()->asArray()->orderBy('name')->all(), 'roomtypeid', 'name');

        echo $form->field($model, 'roomtypeid')->widget(Select2::classname(), [
            'data' =>$data,
            'options' => ['placeholder' => 'Select a room type ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
    ?>

    <?php 
        $data = [];
        $data += yii\helpers\ArrayHelper::map(\app\models\RoomStatus::find()->asArray()->orderBy('name')->all(), 'roomstatusid', 'name');

        echo $form->field($model, 'roomstatusid')->widget(Select2::classname(), [
            'data' =>$data,
            'options' => ['placeholder' => 'Select a room type ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
    ?>
</div>
<div class="box-footer">
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>

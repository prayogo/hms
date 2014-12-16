<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\daterange\DateRangePicker;
use kartik\datecontrol\Module;
use kartik\datecontrol\DateControl;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\RoomReservation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="room-reservation-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?php 
$disabled = false;
if (!$model->isNewRecord){
    $disabled = true;
}

    $data = [];
    $data += yii\helpers\ArrayHelper::map(\app\models\Room::find()->asArray()->orderBy('name')->all(), 'roomid', 'name');
    echo $form->field($model, 'roomid')->widget(Select2::classname(), [
        'data' => $data,
        'disabled' => $disabled,
        'options' => ['placeholder' => 'Select a room ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);

    ?>

    <?php

    echo $form->field($model, 'startdate',[
        'template'=>'{label}{input}</div>{hint}{error}',

    ])->widget(DateRangePicker::classname(),
    [
        'convertFormat'=>true,
        'useWithAddon'=>true,
        'hideInput'=>1, 
        'pluginOptions'=>[
            'format'=>'d/M/Y',
            'separator'=>' - '
        ],        

    ]);

    ?>

    <?php
        echo $form->field($model, 'deposit')->textInput(
        [
            'data-mask'=>'000.000.000.000.000',
            'data-mask-reverse'=>'true',
        ])
    ?>

    <?php
        $data = [];
        $data += yii\helpers\ArrayHelper::map(\app\models\RoomStatus::find()->asArray()->orderBy('name')->all(), 'roomstatusid', 'name');

        echo $form->field($model, 'roomstatusid')->widget(Select2::classname(), [
            'data' => $data,
            'options' => ['placeholder' => 'Select a room status ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
    ?>

    <?php
        $sql = "select customerid, concat(name,' - ',address) as descr from ps_customer";  
        $data = [];
        $data += yii\helpers\ArrayHelper::map(\app\models\Customer::findBySql($sql)
            ->asArray()
            ->orderBy('name')
            ->all(), 'customerid', 'descr');

        echo $form->field($model, 'customerid')->widget(Select2::classname(), [
            'data' => $data,
            'disabled' => $disabled,
            'options' => ['placeholder' => 'Select a customer ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
    ?>

    <?php
        echo $form->field($model, 'out')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Enter check out date ...'],
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'dd-M-yyyy',
            ],
        ]);
    ?>

    <?php
        echo $form->field($model, 'cancel')->radioList(['Y' => 'Yes', 'N' => 'No'],['separator'=>'<span style="margin-right:20px"></span>']);
    ?>
    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?php
    
    $this->registerJsFile(yii\helpers\BaseUrl::base()."/plugin/igorescobar/jquery-2.1.1.min.js", [\yii\web\View::POS_END]);
    $this->registerJsFile(yii\helpers\BaseUrl::base()."/plugin/igorescobar/jquery.mask.js", [\yii\web\View::POS_END]);
    
    ?>

</div>
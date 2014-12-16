<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\datecontrol\Module;
use kartik\datecontrol\DateControl;
use kartik\date\DatePicker;
use kartik\time\TimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\ExtraService */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="extra-service-form">

    <?php $form = ActiveForm::begin(); ?>    

    <?php    	
    	$sql = "select roomreservationid, ps_room.name from ps_roomreservation left join ps_room on ps_roomreservation.roomid = ps_room.roomid where roomreservationid = ". $model->roomreservationid;  
        $data = [];
        $data += yii\helpers\ArrayHelper::map(\app\models\RoomReservation::findBySql($sql)
            ->asArray()
            ->all(), 'roomreservationid', 'name');

        echo $form->field($model, 'roomreservationid')->widget(Select2::classname(), [
            'data' => $data,
            'options' => ['placeholder' => 'Select a room reservation ...'],
            'pluginOptions' => [
            ],
        ]);

    ?>

    <?php

    $data = [];
    $data += yii\helpers\ArrayHelper::map(\app\models\ServiceItem::find()->asArray()->orderBy('name')->all(), 'serviceitemid', 'name');
    echo $form->field($model, 'serviceitemid')->widget(Select2::classname(), [
        'data' => $data,
        'options' => ['placeholder' => 'Select a item ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);

    ?>

    <?= $form->field($model, 'quantity')->textInput([
            'data-mask'=>'000.000.000.000.000',
            'data-mask-reverse'=>'true',
        ]) ?>
  	
  	<?php
        echo $form->field($model, 'date')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Enter purchase date ...'],
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'dd-M-yyyy',
            ],
        ]);

        echo $form->field($model, 'time')->widget(TimePicker::classname(), [
        	'value'=>'18:00',
        	'pluginOptions' => [
        	'showMeridian' => false,
        	]
        ]);
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

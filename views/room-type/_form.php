<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\slider\Slider;
use app\models\Equipment;

/* @var $this yii\web\View */
/* @var $model app\models\RoomType */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="room-type-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 50]) ?>

    <?= $form->field($model, 'singleb')->widget(Slider::classname(), [
        'sliderColor'   =>Slider::TYPE_SUCCESS,
        'handleColor'   =>Slider::TYPE_SUCCESS,
        'pluginOptions' =>[
            'min'   => 0,
            'max'   => 8,
            'step'  => 1,
        ],
    ]); ?>

    <?= $form->field($model, 'doubleb')->widget(Slider::classname(), [
        'sliderColor'   =>Slider::TYPE_SUCCESS,
        'handleColor'   =>Slider::TYPE_SUCCESS,
        'pluginOptions' =>[
            'min'   => 0,
            'max'   => 8,
            'step'  => 1,
        ],
    ]); ?>

    <?= $form->field($model, 'extrab')->widget(Slider::classname(), [
        'sliderColor'   =>Slider::TYPE_SUCCESS,
        'handleColor'   =>Slider::TYPE_SUCCESS,
        'pluginOptions' =>[
            'min'   => 0,
            'max'   => 8,
            'step'  => 1,
        ],
    ]); ?>

    <?= $form->field($model, 'maxchild')->widget(Slider::classname(), [
        'sliderColor'   =>Slider::TYPE_DANGER,
        'handleColor'   =>Slider::TYPE_DANGER,
        'pluginOptions' =>[
            'min'   => 0,
            'max'   => 8,
            'step'  => 1,
        ],
    ]); ?>

    <?= $form->field($model, 'maxadult')->widget(Slider::classname(), [
        'sliderColor'   =>Slider::TYPE_DANGER,
        'handleColor'   =>Slider::TYPE_DANGER,
        'pluginOptions' =>[
            'min'   => 0,
            'max'   => 8,
            'step'  => 1,
        ],
    ]); ?>

    <?= $form->field($model, 'varchildCharge')->textInput(
        [
            'data-mask'=>'000.000.000.000.000',
            'data-mask-reverse'=>'true',
        ]);
    ?>

    <?= $form->field($model, 'varadultCharge')->textInput(
        [
            'data-mask'=>'000.000.000.000.000',
            'data-mask-reverse'=>'true',
        ]);
    ?>

    <?= $form->field($model, 'varrate')->textInput(
        [
            'data-mask'=>'000.000.000.000.000',
            'data-mask-reverse'=>'true',
        ]);
    ?>

    <?= $form->field($model, 'weekendrate')->widget(Slider::classname(), [
        'sliderColor'   =>Slider::TYPE_PRIMARY,
        'handleColor'   =>Slider::TYPE_PRIMARY,
        'pluginOptions' =>[
            'min'   => -100,
            'max'   => 100,
            'step'  => 1,
        ],
    ]); ?>

    <?= $form->field($model, 'description')->textArea(['maxlength' => 250, 'style'=>'height:120px']) ?>

    <?php 
        $equipment = new \app\models\RoomTypeEquipment();
        $checkedEquipment = [];
        if (!$model->isNewRecord){
            $existequip = $equipment->find()->where(
                'roomtypeid = :1',[':1'=>$model->roomtypeid,])->asArray()->all();
            foreach($existequip as $equip){
                array_push($checkedEquipment, $equip["equipmentid"]);
            }
        }
        
        $data = [];
        $data += yii\helpers\ArrayHelper::map(Equipment::find()->asArray()->all(), 'equipmentid', 'name');
        $equipment->equipmentid = $checkedEquipment;
        echo $form->field($equipment, 'equipmentid')->checkboxlist($data, [
            'separator'=>'<br>','style'=>'height:150px; overflow-y:scroll','class'=>'panel panel-body panel-default'
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

<style>
    .control-label{
        width:120px;
    }
</style>
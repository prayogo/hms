<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\slider\Slider;
use app\models\Equipment;
use app\models\Discount;

/* @var $this yii\web\View */
/* @var $model app\models\RoomType */
/* @var $form yii\widgets\ActiveForm */
\yii\web\jQueryAsset::register($this);
\app\assets\InputMaskAsset::register($this);

$tax = \app\models\Tax::find()->one();
?>

<?php $form = ActiveForm::begin(); ?>

<div class="box-body">
    <?= $form->field($model, 'name')->textInput(['maxlength' => 50]) ?>
    <?= $form->field($model, 'code')->textInput(['maxlength' => 8]) ?>

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

    <?= $form->field($model, 'varchildCharge', ['template' => '{label}<div class="input-group">
            <span class="input-group-addon">'.$tax->currency.'</span>{input}</div>{hint}{error}'])
        ->textInput([
            'data-mask'=>'000.000.000.000.000',
            'data-mask-reverse'=>'true',
        ]);
    ?>

    <?= $form->field($model, 'varadultCharge', ['template' => '{label}<div class="input-group">
            <span class="input-group-addon">'.$tax->currency.'</span>{input}</div>{hint}{error}'])
        ->textInput([
            'data-mask'=>'000.000.000.000.000',
            'data-mask-reverse'=>'true',
        ]);
    ?>

    <?= $form->field($model, 'varrate', ['template' => '{label}<div class="input-group">
            <span class="input-group-addon">'.$tax->currency.'</span>{input}</div>{hint}{error}'])
        ->textInput([
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
        $data = [];
        $data += yii\helpers\ArrayHelper::map(Equipment::find()->asArray()->all(), 'equipmentid', 'name');

        echo $form->field($model, 'equipments', ['template'=>'{label}<div class="box-body panel panel-body panel-default">{input}</div>'])
        ->checkboxlist($data, [
            'style'=>'height:150px; overflow-y:scroll','class'=>'row',
            'itemOptions'=>['labelOptions'=>['class'=>'col-md-4']]
        ]);
    ?>

    <?php
        $data = [];
        $data += yii\helpers\ArrayHelper::map(Discount::find()->asArray()->all(), 'discountid', 'name');

        echo $form->field($model, 'discounts', ['template'=>'{label}<div class="panel panel-body panel-default box-body">{input}</div>'])
            ->checkboxlist($data, [
                'style'=>'height:150px; overflow-y:scroll;','class'=>'row', 'tag'=>'div',
                'itemOptions'=>['labelOptions'=>['class'=>'col-md-6']]
            ]);
    ?>


</div>
<div class="box-footer">
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>

<style>
    .control-label{
        width:120px;
    }
    .box-body{
        padding: 15px;
    }
</style>
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use kartik\tabs\TabsX;
use kartik\select2\Select2;
use kartik\slider\Slider;

\yii\web\jQueryAsset::register($this);
\app\assets\Select2Asset::register($this);


/* @var $this yii\web\View */
/* @var $searchModel app\models\HotelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Hotel Information: Update';
$this->params['breadcrumbs'][] = ['label' => 'Hotel Information', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<section class="content-header">
  <h1><?= Html::encode($this->title) ?></h1>
  <?= yii\widgets\Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
  ]) ?>
</section>

<section class="content">

<div class="hotel-index">

    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
<?php $form = ActiveForm::begin(['options'=>['class'=>'form-horizontal']]); ?>
<?php echo $form->errorSummary($model, ['class'=>'callout callout-danger' ]);?> 
    <div>
    <?php
        $data = [];
        $data += yii\helpers\ArrayHelper::map(\app\models\Location::find()->asArray()->orderBy('name')->all(), 'locationid', 'name');

        $hotel = '
            <h4><i class="glyphicon glyphicon-home"></i> Hotel Information</h4>'.
                    $form->field($model, 'name', [
                        'labelOptions'=>['class'=>'col-sm-2 control-label'], 
                        'template' => '{label}<div class="col-sm-9">{input}{hint}{error}</div>'
                    ])->textInput(['maxlength' => 50]).

                    $form->field($model, 'address', [
                        'labelOptions'=>['class'=>'col-sm-2 control-label'], 
                        'template' => '{label}<div class="col-sm-9">{input}{hint}{error}</div>'
                    ])->textArea(['maxlength' => 150, 'style'=>'height:80px']).

                    $form->field($model, 'city', [
                        'labelOptions'=>['class'=>'col-sm-2 control-label'], 
                        'template' => '{label}<div class="col-sm-9">{input}{hint}{error}</div>'
                    ])->textInput(['maxlength' => 50]).

                    $form->field($model, 'state', [
                        'labelOptions'=>['class'=>'col-sm-2 control-label'], 
                        'template' => '{label}<div class="col-sm-9">{input}{hint}{error}</div>'
                    ])->textInput(['maxlength' => 150]).

  
                    $form->field($model, 'locationid', [
                        'labelOptions'=>['class'=>'col-sm-2 control-label'], 
                        'template' => '{label}<div class="col-sm-9">{input}{hint}{error}</div>'
                    ])->dropDownList($data)
                    .

                    $form->field($model, 'email', [
                        'labelOptions'=>['class'=>'col-sm-2 control-label'], 
                        'template' => '{label}<div class="col-sm-9">{input}{hint}{error}</div>'
                    ])->textInput(['maxlength' => 150]).

                    $form->field($model, 'phone1', [
                        'labelOptions'=>['class'=>'col-sm-2 control-label'], 
                        'template' => '{label}<div class="col-sm-9">{input}{hint}{error}</div>'
                    ])->textInput(['maxlength' => 15]).

                    $form->field($model, 'phone2', [
                        'labelOptions'=>['class'=>'col-sm-2 control-label'], 
                        'template' => '{label}<div class="col-sm-9">{input}{hint}{error}</div>'
                    ])->textInput(['maxlength' => 15]).

                    $form->field($model, 'fax', [
                        'labelOptions'=>['class'=>'col-sm-2 control-label'], 
                        'template' => '{label}<div class="col-sm-9">{input}{hint}{error}</div>'
                    ])->textInput(['maxlength' => 15])
                    .'';
        
        $contactperson = '   
            <h4><i class="glyphicon glyphicon-user"></i> Contact Person</h4>'.
                    
                    $form->field($contact, 'name', [
                        'labelOptions'=>['class'=>'col-sm-2 control-label'], 
                        'template' => '{label}<div class="col-sm-9">{input}{hint}{error}</div>'
                    ])->textInput(['maxlength' => 50]).

                    $form->field($contact, 'address', [
                        'labelOptions'=>['class'=>'col-sm-2 control-label'], 
                        'template' => '{label}<div class="col-sm-9">{input}{hint}{error}</div>'
                    ])->textArea(['maxlength' => 150, 'style'=>'height:80px']).

                    $form->field($contact, 'email', [
                        'labelOptions'=>['class'=>'col-sm-2 control-label'], 
                        'template' => '{label}<div class="col-sm-9">{input}{hint}{error}</div>'
                    ])->textInput(['maxlength' => 150]).

                    $form->field($contact, 'phone', [
                        'labelOptions'=>['class'=>'col-sm-2 control-label'], 
                        'template' => '{label}<div class="col-sm-9">{input}{hint}{error}</div>'
                    ])->textInput(['maxlength' => 20]).

                    $form->field($contact, 'phone2', [
                        'labelOptions'=>['class'=>'col-sm-2 control-label'], 
                        'template' => '{label}<div class="col-sm-9">{input}{hint}{error}</div>'
                    ])->textInput(['maxlength' => 20])

                .'';

        $bankinfo = '<h4><i class="fa fa-bank"></i> Bank Information</h4>'.
                    $form->field($bank, 'name', [
                        'labelOptions'=>['class'=>'col-sm-2 control-label'], 
                        'template' => '{label}<div class="col-sm-9">{input}{hint}{error}</div>'
                    ])->textInput(['maxlength' => 50]) .

                    $form->field($bank, 'accountno', [
                        'labelOptions'=>['class'=>'col-sm-2 control-label'], 
                        'template' => '{label}<div class="col-sm-9">{input}{hint}{error}</div>'
                    ])->textInput(['maxlength' => 50]) .

                    $form->field($bank, 'branch', [
                        'labelOptions'=>['class'=>'col-sm-2 control-label'], 
                        'template' => '{label}<div class="col-sm-9">{input}{hint}{error}</div>'
                    ])->textInput(['maxlength' => 50])

        ;

        $tax = '
            <h4><i class="fa fa-calculator"></i> Tax Configuration</h4>'.
                    
                    $form->field($tax, 'room', [
                        'labelOptions'=>['class'=>'col-sm-2 control-label'], 
                        'template' => '{label}<div class="col-sm-10">{input}{hint}{error}</div>'
                    ])->widget(Slider::classname(), [
                        'sliderColor'   =>Slider::TYPE_DANGER,
                        'handleColor'   =>Slider::TYPE_DANGER,
                        'pluginOptions' =>[
                            'min'   => 0,
                            'max'   => 100,
                            'step'  => 1,
                        ],
                    ]) .

                    $form->field($tax, 'meal', [
                        'labelOptions'=>['class'=>'col-sm-2 control-label'], 
                        'template' => '{label}<div class="col-sm-10">{input}{hint}{error}</div>'
                    ])->widget(Slider::classname(), [
                        'sliderColor'   =>Slider::TYPE_DANGER,
                        'handleColor'   =>Slider::TYPE_DANGER,
                        'pluginOptions' =>[
                            'min'   => 0,
                            'max'   => 100,
                            'step'  => 1,
                        ],
                    ]) .

                    $form->field($tax, 'product', [
                        'labelOptions'=>['class'=>'col-sm-2 control-label'], 
                        'template' => '{label}<div class="col-sm-10">{input}{hint}{error}</div>'
                    ])->widget(Slider::classname(), [
                        'sliderColor'   =>Slider::TYPE_DANGER,
                        'handleColor'   =>Slider::TYPE_DANGER,
                        'pluginOptions' =>[
                            'min'   => 0,
                            'max'   => 100,
                            'step'  => 1,
                        ],
                    ]) .

                    $form->field($tax, 'currency', [
                        'labelOptions'=>['class'=>'col-sm-2 control-label'], 
                        'template' => '{label}<div class="col-sm-3">{input}{hint}{error}</div>'
                    ])->textInput(['maxlength' => 5])

                    .'
        ';

        $items = [
            [
                'label'=>'<i class="glyphicon glyphicon-home"></i> Hotel Information',
                'content'=>$hotel,
                'active'=>true
            ],
            [
                'label'=>'<i class="fa fa-calculator"></i> Tax Configuration',
                'content'=>$tax,  
            ],
            [
                'label'=>'<i class="glyphicon glyphicon-user"></i> Contact Person',
                'content'=>$contactperson,
            ],
            [
                'label'=>'<i class="fa fa-bank"></i> Bank Information',
                'content'=>$bankinfo,  
            ],
        ];       

        echo TabsX::widget([
            'items'=>$items,
            'position'=>TabsX::POS_ABOVE,
            'encodeLabels'=>false,
            'bordered'=>true,
            'containerOptions'=>['class'=>'nav-tabs-custom']
        ]);
    ?> 
    </div>
    <div class="form-group button-update">
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
    </div>
<?php ActiveForm::end(); ?>
</div>

</section>



<style>
    h4{
        border-bottom: 2px solid gray;
        padding-bottom: 8px;
        margin-bottom: 15px;
    }
    .button-update{
        margin-left:0px !important;
        margin-top:10px;
    }
</style>

<?php

$this->registerJs('

$("#hotel-locationid").select2({
    tags: "true",
    placeholder: "Select location..",
    allowClear: true,
});
$("#hotel-locationid").on("change", function (e) { 
    if ($(this).val() == null || $(this).val() == ""){
        $(this).closest(".field-hotel-locationid").find(".select2-container--default .select2-selection--single, .select2-selection .select2-selection--single").css("border-color", "#dd4b39");
    }else{
        $(this).closest(".field-hotel-locationid").find(".select2-container--default .select2-selection--single, .select2-selection .select2-selection--single").css("border-color", "#00a65a");
    }
});

', \yii\web\View::POS_END);
?>


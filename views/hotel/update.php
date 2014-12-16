<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use kartik\tabs\TabsX;
use kartik\select2\Select2;
use kartik\slider\Slider;

/* @var $this yii\web\View */
/* @var $searchModel app\models\HotelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Hotel Information: Update';
$this->params['breadcrumbs'][] = ['label' => 'Hotel Information', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="hotel-index">

    <h1>
        <img height="50px" src="<?=\Yii::$app->request->BaseUrl?>/img/hotel.png"/>
        <span style="vertical-align: middle;"><?= Html::encode($this->title) ?></span></h1>
    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
<?php $form = ActiveForm::begin(['options'=>['class'=>'form-horizontal']]); ?>
<?php echo $form->errorSummary([]);?> 
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
                    ])->widget(Select2::classname(), [
                        'data' =>$data,
                        'options' => ['placeholder' => 'Select a location ...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]).

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
        ]);
    ?> 
    </div>
    <div class="form-group button-update">
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
    </div>
<?php ActiveForm::end(); ?>
</div>

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
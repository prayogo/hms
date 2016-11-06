<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\datecontrol\Module;
use kartik\datecontrol\DateControl;
use kartik\date\DatePicker;

\yii\web\jQueryAsset::register($this);
\app\assets\Select2Asset::register($this);

/* @var $this yii\web\View */
/* @var $model app\models\Customer */
/* @var $form yii\widgets\ActiveForm */
?>


    <?php $form = ActiveForm::begin(); ?>

<div class="box-body">

    <?= $form->field($model, 'name')->textInput(['maxlength' => 50]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => 150]) ?>

    <?php 

    $data = [];
    $data += yii\helpers\ArrayHelper::map(\app\models\Location::find()->asArray()->orderBy('name')->all(), 'locationid', 'name');

    echo $form->field($model, 'locationid')->dropDownList($data);

    ?>

    <div style="margin-top:-3px" class="form-group divphone">
        <?php 
            $phone = new \app\models\CustomerPhone();
            echo Html::activeLabel($phone, 'phone');
        ?>
        <div id="phone">
            <?php
                if (isset($customerPhone) && $customerPhone != null){
                    $index = 1;
                    foreach($customerPhone as $phone){
                        if ($phone->hasErrors('phone')){
                            echo $this->render('phone/_form',  ['model' => $phone, 'index' => $index,]);
                        }else{
                            echo $this->render('phone/_form',  ['model' => $phone, 'index' => $index, ]);
                        }
                        $index++;
                    }
                }
            ?>
        </div>
    </div>

    <div style="margin-top:-3px" class="form-group dividentification">
        <?php 
            $phone = new \app\models\CustomerIdentification();
            echo Html::activeLabel($phone, 'identificationno');
        ?>
        <div id="identification">
            <?php
                if (isset($customerIdentification) && $customerIdentification != null){
                    $index1 = 1;
                    foreach($customerIdentification as $identification){
                        if ($identification->hasErrors('identificationno')){
                            echo $this->render('identification/_form',  ['model' => $identification, 'index' => $index1,]);
                        }else{
                            echo $this->render('identification/_form',  ['model' => $identification, 'index' => $index1,]);
                        }
                        $index1++;
                    }
                }
            ?>
        </div>
    </div>

</div>

<div class="box-footer">
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

    <?php ActiveForm::end(); ?>

<?php

$this->registerJs('

$("#customer-locationid").select2({
    tags: "true",
    placeholder: "Select location..",
    allowClear: true,
});
$("#customer-locationid").on("change", function (e) { 
    if ($(this).val() == null || $(this).val() == ""){
        $(this).closest(".field-customer-locationid").find(".select2-container--default .select2-selection--single, .select2-selection .select2-selection--single").css("border-color", "#dd4b39");
    }else{
        $(this).closest(".field-customer-locationid").find(".select2-container--default .select2-selection--single, .select2-selection .select2-selection--single").css("border-color", "#00a65a");
    }
});

var _index = ' . $index . ';
var _index1 = ' . $index1 . ';
function addPhone(){
    var _url = "' . yii\helpers\Url::toRoute('customer/render-phone') . '?index="+_index;
    $.ajax({
        url: _url,
        success:function(response){
            $("#phone").append(response);
            $("#phone .crow").last().animate({
                opacity : 1, 
                left: "+50", 
                height: "toggle"
            });
            $(".btnDeletePhone").click(function (elm){ 
                if ($("#phone").find("input").length >1){
                    element=$(elm.currentTarget).closest(".customer-phone-form");
                    /* animate div */
                    $(element).animate(
                    {
                        opacity: 0.25,
                        left: "+=50",
                        height: "toggle"
                    }, 400,
                    function() {
                        /* remove div */
                        $(element).remove();
                        if ($("#phone").find("div.has-error").length < 1){
                            $(".divphone").find("label").css("color", "");
                        }
                    });
                    

                }else{
                    alert("Required at least one phone number.");
                }                
            });

            $(".btnAddPhone").click(function (elm){
                $( ".btnAddPhone").unbind( "click" );
                addPhone();
            });
        }
    });
    _index++;
}

if ($("#phone").find("input").length == 0){
    addPhone();
}

/*$("#w0").submit(function(e){
    var flag = true;
    $(".phoneinput").each(function( e ) {
        if ($(this).val() == ""){
            $(this).closest(".form-group").attr("class", "form-group required has-error");
            $(this).closest(".form-group").find(".help-block").text("Phone cannot be blank.");
            $(this).closest(".divphone").find("label").css("color", "#a94442");
            flag = false;
        }else{
            $(this).closest(".form-group").attr("class", "form-group required has-success");
            $(this).closest(".form-group").find(".help-block").text("");
            $(this).closest(".divphone").find("label").css("color", "#3c763d");
        }
    });

    $(".identificationinput").each(function( e ) {

        if ($(this).val() == "" || 
            $(this).closest(".customer-identification-form").find("select").val() == ""){
            
            $(this).closest(".form-group").attr("class", "form-group required has-error");
            $(this).closest(".customer-identification-form").find("select").closest(".form-group").find(".select2-container--default .select2-selection--single, .select2-selection .select2-selection--single").css("border-color", "#dd4b39");

            $(this).closest(".customer-identification-form").find(".help-block").text("Identification cannot be blank.");
            $(this).closest(".customer-identification-form").find(".help-block").css("color","#a94442");
            flag = false;
        }else{
            $(this).closest(".form-group").attr("class", "form-group required has-success");
            $(this).closest(".customer-identification-form").find("select").closest(".form-group").find(".select2-container--default .select2-selection--single, .select2-selection .select2-selection--single").css("border-color", "#00a65a");
            $(this).closest(".customer-identification-form").find(".help-block").text("");
            $(this).closest(".customer-identification-form").find(".help-block").css("color","#3c763d");
        }

        if ($("#identification").find("div.has-error").length > 0){
            $(".dividentification").find("label").css("color", "#a94442");
            flag = false;
        }else{
            $(".dividentification").find("label").css("color", "#3c763d");
        }
    });

    return flag;
});*/

$(".btnDeletePhone").click(function (elm){ 
    if ($("#phone").find("input").length >1){
     
        element=$(elm.currentTarget).closest(".customer-phone-form");
        /* animate div */
        $(element).animate(
        {
            opacity: 0.25,
            left: "+=50",
            height: "toggle"
        }, 400,
        function() {
            /* remove div */
            $(element).remove();
            if ($("#phone").find("div.has-error").length < 1){
                $(".divphone").find("label").css("color", "");
            }
        });
    }else{
        alert("Required at least one phone number.");
    }                
});

$(".btnAddPhone").click(function (elm){
    $( ".btnAddPhone").unbind( "click" );
    addPhone();
});

$(".phoneinput").blur(function(e){
    if ($(e.currentTarget).val() == ""){
        $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-error");
        $(e.currentTarget).closest(".form-group").find(".help-block").text("Phone cannot be blank.");
        $(e.currentTarget).closest(".divphone").find("label").css("color", "#a94442");
    }else{
        $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-success");
        $(e.currentTarget).closest(".form-group").find(".help-block").text("");
        $(e.currentTarget).closest(".divphone").find("label").css("color", "#3c763d");
    }
});

if ($("#phone").find("div.has-error").length > 0){
    $(".divphone").find("label").css("color", "#a94442");
}


function addIdentification(){
    var _url = "' . yii\helpers\Url::toRoute('customer/render-identification') . '?index="+(_index1);
    $.ajax({
        url: _url,
        success:function(response){
            $("#identification").append(response);
            
            $("#customeridentification-"+(_index1)+"-identificationtypeid").select2();

            $("#identification .crow").last().animate({
                opacity : 1, 
                left: "+50", 
                height: "toggle"
            });
            $(".btnDeleteIdentification").click(function (elm){ 
                elm.stopImmediatePropagation();
                if ($("#identification").find("input").length > 3){
                 
                    element=$(elm.currentTarget).closest(".customer-identification-form");
                    /* animate div */
                    $(element).animate(
                    {
                        opacity: 0.25,
                        left: "+=50",
                        height: "toggle"
                    }, 400,
                    function() {
                        /* remove div */
                        $(element).remove();
                        if ($("#identification").find("div.has-error").length < 1){
                            $(".dividentification").find("label").css("color", "");
                        }
                    });
                }else{
                    alert("Required at least one identification.");
                }                
            });

            $(".btnAddIdentification").click(function (elm){
                $( ".btnAddIdentification").unbind( "click" );
                addIdentification();
            });

            $(".identificationinput").blur(function(e){
                
                if ($(e.currentTarget).val() == "" || 
                    $(e.currentTarget).closest(".customer-identification-form").find("select").val() == ""){
                    
                    $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-error");
                    $(e.currentTarget).closest(".customer-identification-form").find("select").closest(".form-group").attr("class", "form-group required has-error");

                    $(e.currentTarget).closest(".customer-identification-form").find(".help-block").text("Identification cannot be blank.");
                    $(e.currentTarget).closest(".customer-identification-form").find(".help-block").css("color","#a94442");
                }else{
                    $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-success");
                    $(e.currentTarget).closest(".customer-identification-form").find("select").closest(".form-group").attr("class", "form-group required has-success");
                    $(e.currentTarget).closest(".customer-identification-form").find(".help-block").text("");
                    $(e.currentTarget).closest(".customer-identification-form").find(".help-block").css("color","#3c763d");
                }

                if ($("#identification").find("div.has-error").length > 0){
                    $(".dividentification").find("label").css("color", "#a94442");
                }else{
                    $(".dividentification").find("label").css("color", "#3c763d");
                }

            });
            _index1++;
        }
    });
}

if ($("#identification").find("input").length == 0){
    addIdentification();    
}

$(".btnDeleteIdentification").click(function (elm){ 
    elm.stopImmediatePropagation();
    if ($("#identification").find("input").length > 3){
     
        element=$(elm.currentTarget).closest(".customer-identification-form");
        /* animate div */
        $(element).animate(
        {
            opacity: 0.25,
            left: "+=50",
            height: "toggle"
        }, 400,
        function() {
            /* remove div */
            $(element).remove();
            if ($("#identification").find("div.has-error").length < 1){
                $(".dividentification").find("label").css("color", "");
            }
        });
    }else{
        alert("Required at least one identification.");
    }                
});

$(".btnAddIdentification").click(function (elm){
    $( ".btnAddIdentification").unbind( "click" );
    addIdentification();
});

$(".identificationinput").blur(function(e){
    
    if ($(e.currentTarget).val() == "" || 
        $(e.currentTarget).closest(".customer-identification-form").find("select").val() == ""){
        
        $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-error");
        $(e.currentTarget).closest(".customer-identification-form").find("select").closest(".form-group").attr("class", "form-group required has-error");

        $(e.currentTarget).closest(".customer-identification-form").find(".help-block").text("Identification cannot be blank.");
        $(e.currentTarget).closest(".customer-identification-form").find(".help-block").css("color","#a94442");
    }else{
        $(e.currentTarget).closest(".form-group").attr("class", "form-group required has-success");
        $(e.currentTarget).closest(".customer-identification-form").find("select").closest(".form-group").attr("class", "form-group required has-success");
        $(e.currentTarget).closest(".customer-identification-form").find(".help-block").text("");
        $(e.currentTarget).closest(".customer-identification-form").find(".help-block").css("color","#3c763d");
    }

    if ($("#identification").find("div.has-error").length > 0){
        $(".dividentification").find("label").css("color", "#a94442");
    }else{
        $(".dividentification").find("label").css("color", "#3c763d");
    }

});

if ($("#identification").find("div.has-error").length > 0){
    $(".dividentification").find("label").css("color", "#a94442");
}

$(".identificationddl").select2();


', \yii\web\View::POS_END);
?>


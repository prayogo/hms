<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\datecontrol\Module;
use kartik\datecontrol\DateControl;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Payment */
/* @var $form yii\widgets\ActiveForm */

?>
<script>
    var pajak = <?= \app\models\Tax::find()->orderBy('taxid desc')->one()->room ?>;
    var currency = '<?= \app\models\Tax::find()->orderBy('taxid desc')->one()->currency ?>';
    
    function countdebit(){
        var debitsub = 0;
        var charge = 0;
        $('#payment td.debit').each(function(e){
            debitsub = debitsub + parseInt($(this).text().replace(/,/g,''));
        });

        $('#payment .charge').each(function(e){
            charge = charge + parseInt($(this).text().replace(/,/g,''));
        });

        var pajakText = (debitsub * pajak/100).toFixed(1).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        var text = debitsub.toFixed(1).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        var chargeText = charge.toFixed(1).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        $('#debit-subtotal').text(text.substr(0, text.length-2));
        $('#debit-pajak').text(pajakText.substr(0, pajakText.length-2));
        
        var total = (charge + debitsub + debitsub * pajak/100).toFixed(1).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        $('#debit-total').text(total.substr(0, total.length-2));
        $('#debit-cas').text(chargeText.substr(0, chargeText.length-2));
        $('.currency').text(currency);
        
    }

    document.addEventListener("DOMContentLoaded", function(event) { 
        $('.currency').text(currency);
        $('#payment-amountpaid').keyup(function(e){
            var paid = parseInt(this.value.replace(/,/g,''));
            var total = parseInt($('#debit-total').text().replace(/,/g,''));
            var style = '';
            if (paid - total < 0){
                style = 'red';
            }
            $('#sisa').text(paid - total).css('color', style);            
        });
    });


	function loadreservation(){
		$('#reservation').empty();
        $('#reservation').append('<tr id="loader"><td colspan=5 class=text-center><img style="text-align:center" width="30px" src="<?= yii\helpers\BaseUrl::base()?>/css/loading.gif"></td></tr>');
		$.ajax({
		  	url: "<?= yii\helpers\Url::toRoute('payment/room-reservation') ?>",
		  	type: "GET",
            async: false,
		  	data: { 'customer' : $('#payment-customerid').val() },
		  	dataType: "json",
		  	success: function(result){
                if(result.length > 0){
                    for(var i = 0; i < result.length; i++){
                        $('#reservation').append('<tr><td><input class="room-reservation" type="checkbox" name="Payment[RoomReservationPayment]['+(i+1)+']" id="room-reservation-'+result[i].roomreservationid+'" value="'+result[i].roomreservationid+'"></td><td>'+result[i].name+'</td><td>'+result[i].startdate+'</td><td>'+result[i].enddate+'</td><td>'+result[i].checkout+'</td><td>'+currency+' '+result[i].deposit+'</td></tr>');
                    }    

                    $('.room-reservation').change(function(e){
                        if (this.checked){
                            $.ajax({
                                url: "<?= yii\helpers\Url::toRoute('payment/room-reservation-rate') ?>",
                                type: "GET",
                                async: false,
                                data: { 'reservation' : this.value },
                                dataType: "json",
                                success: function(result1){
                                    for(var j = 0; j < result1.length; j++){
                                        $('#payment').append('<tr class="payment-view-'+result1[j].reservation+'"><td>'+result1[j].date+'</td><td>'+result1[j].service+'</td><td class="currency"></td><td class="text-right debit">'+result1[j].debit+'</td><td class="credit" colspan=2>'+result1[j].credit+'</td><td class="charge">'+result1[j].charge+'</td></tr>');

                                    }
                                }
                            });
                        }else{
                            $('.payment-view-'+this.value).remove();
                        }

                        countdebit();

                    });
                }else{
                    $('#reservation').append('<tr><td class="text-center" colspan=5>No data.</td></tr>');
                }

                $('#loader').remove();
		  	}
		});
	}
</script>

<div class="payment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    $data = [];
    $sql = "select distinct a.customerid, concat(a.name, ' - ', a.address) as name from ps_customer a join ps_roomreservation b on a.customerid = b.customerid and b.cancel = 'N' and b.out is not null where b.roomreservationid not in (select roomreservationid from ps_reservationpayment)";
    $data += yii\helpers\ArrayHelper::map(\app\models\Customer::findBySql($sql)->asArray()->orderBy('name')->all(), 'customerid', 'name');

    echo $form->field($model, 'customerid')->widget(Select2::classname(), [
        'data' =>$data,
        'options' => ['placeholder' => 'Select a customer ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
        'pluginEvents' => [
        	 'change' => 'loadreservation',
        ]
    ]);
    ?>

    <?php
        echo $form->field($model, 'date')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Enter payment date ...'],
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'dd-M-yyyy',
            ],
        ]);
    ?>

    <div class="form-group">
    	<label>Room Reservation</label>
    	<div>
    		<table class="table table-striped">
    			<thead>
    				<th></th>
    				<th>Name</th>
    				<th>Start Date</th>
    				<th>End Date</th>
    				<th>Check Out</th>
    				<th>Deposit</th>
    			</thead>
    			<tbody id="reservation">
                    <tr>
                        <td colspan=5 class="text-center">No data.</td>
                    </tr>
    			</tbody>
    		</table>
    	</div>
    </div>

    <div class="form-group">
        <label>Payment</label>
        <div>
            <table class="table table-striped">
                <thead>
                    <th>Date</th>
                    <th>Service</th>
                    <th colspan=2>Debit</th>
                    <th colspan=2>Credit</th>
                </thead>
                <tbody id="payment">
                    
                </tbody>
                <tfooter>
                    <tr>
                        <td colspan=2 class="text-right">Subtotal</td>
                        <td class="currency"></td>
                        <td id="debit-subtotal" class="text-right">0</td>
                        <td id="credit-subtotal" class="text-right" colspan=2></td>
                    </tr>
                    <tr>
                        <td colspan=2 class="text-right">Pajak</td>
                        <td class="currency"></td>
                        <td id="debit-pajak" class="text-right">0</td>
                        <td id="credit-pajak" class="text-right" colspan=2></td>
                    </tr>
                    <tr>
                        <td colspan=2 class="text-right">Cas</td>
                        <td class="currency"></td>
                        <td id="debit-cas" class="text-right">0</td>
                        <td id="credit-cas" class="text-right" colspan=2></td>
                    </tr>
                    <tr>
                        <td colspan=2 class="text-right">Diskon</td>
                        <td id="debit-diskon" class="text-right" colspan=2></td>
                        <td class="currency"></td>
                        <td id="credit-diskon" class="text-right">0</td>
                    </tr>
                </tfooter>
                <tbody>
                    <tr>
                        <td colspan=2 class="text-right"><b>Total</b></td>
                        <td class="currency"></td>
                        <td id="debit-total" class="text-right"><b>0</b></td>
                        <td id="credit-total" class="text-right" colspan=2></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <?= $form->field($model, 'amountpaid')->textInput(
        [
            'data-mask'=>'000,000,000,000,000',
            'data-mask-reverse'=>'true',
        ]) ?>
    
    <div class="form-group">
        <label>Sisa:</label>
        <label id="sisa"></label>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?php
    
    $this->registerJsFile(yii\helpers\BaseUrl::base()."/plugin/igorescobar/jquery-2.1.1.min.js", [\yii\web\View::POS_HEAD]);
    $this->registerJsFile(yii\helpers\BaseUrl::base()."/plugin/igorescobar/jquery.mask.js", [\yii\web\View::POS_END]);

    ?>

<?php
    if ($model->customerid != null && $model->customerid > 0){
        $str = '<script>document.addEventListener("DOMContentLoaded", function(event) { loadreservation(); ';
        foreach($model_reservation as $checked){
            $str = $str . ' $("#room-reservation-'.$checked.'").attr("checked", ""); ';
            $str = $str . ' $("#room-reservation-'.$checked.'").trigger("change"); ';
        }

        $str = $str . " var paid = parseInt($('#payment-amountpaid').val().replace(/,/g,'')); ";
        $str = $str . " var total = parseInt($('#debit-total').text().replace(/,/g,'')); ";
        $str = $str . " var style = ''; ";
        $str = $str . " if (paid - total < 0){ style = 'red'; } ";
        $str = $str . " $('#sisa').text(paid - total).css('color', style); ";
        $str = $str . '}); </script>';
        echo $str;
    }
?>

</div>
<style>
    .highlight{
        margin-right: 0;
        margin-left: 0;
        border-width: 1px;
        border-bottom-right-radius: 4px;
        border-bottom-left-radius: 4px;
        padding: 9px 14px;
        background-color: #f7f7f9;
        border: 1px solid #e1e1e8;
    }
    .charge{
        display:none;
    }
</style>

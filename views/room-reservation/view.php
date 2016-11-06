<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\tabs\TabsX;

/* @var $this yii\web\View */
/* @var $model app\models\RoomReservation */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Room Reservations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<section class="content-header">
  <h1><?= Html::encode($this->title) ?></h1>
  <?= yii\widgets\Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
  ]) ?>
</section>

<section class="content">
    <div class="box box-default">
        <div class="box-body">
            <table class="table table-striped table-condensed">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Kamar</th>
                        <th>Tipe</th>
                        <th>Check In</th>
                        <th>Check Out</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="reservationBody">

                </tbody>
            </table>
        </div>
    </div>
</section>

<?php
    $this->registerJs("
        $( document ).ready(function() {
            Init();
        });
    ", \yii\web\View::POS_END);
?>

<script type="text/javascript">
    function Init(){
        LoadReservation();

        $('#reservationBody').on("click", ".checkin", function(e){
            var reservationdetailid = $(this).siblings('.reservationdetailid').val();
            $.ajax({
                url: '<?= yii\helpers\Url::toRoute("room-reservation/check-in") ?>',
                method: 'POST',
                dataType: 'json',
                data: {"reservationdetailid":reservationdetailid},
                success: function(result){
                    if (result == 1){
                        LoadReservation();
                    }else{
                        if (typeof(result) == "object"){
                            var errorMessage = "";
                            $(result).each(function(i, item){
                                for(var n in item){
                                    errorMessage += result[n].join(". ");
                                }
                            });

                            alert(errorMessage);
                        }else{
                            alert(result);
                        }
                    }
                },
                error: function(err){
                    alert(err.statusText);
                    if (typeof(err.responseJSON) != 'undefined'){
                        if (typeof(err.responseJSON.message) != 'undefined'){
                            console.log(err.responseJSON.message)
                        }
                    }
                }
            });     
        });

        $('#reservationBody').on("click", ".cancel", function(e){
            var r = confirm("Konfirmasi cancel reservasi?");
            if (!r) {
                return;
            }

            var reservationdetailid = $(this).siblings('.reservationdetailid').val();
            $.ajax({
                url: '<?= yii\helpers\Url::toRoute("room-reservation/cancel-reservation") ?>',
                method: 'POST',
                dataType: 'json',
                data: {"reservationdetailid":reservationdetailid},
                success: function(result){
                    if (result == 1){
                        LoadReservation();
                    }else{
                        if (typeof(result) == "object"){
                            var errorMessage = "";
                            $(result).each(function(i, item){
                                for(var n in item){
                                    errorMessage += result[n].join(". ");
                                }
                            });

                            alert(errorMessage);
                        }else{
                            alert(result);
                        }
                    }
                },
                error: function(err){
                    alert(err.statusText);
                    if (typeof(err.responseJSON) != 'undefined'){
                        if (typeof(err.responseJSON.message) != 'undefined'){
                            console.log(err.responseJSON.message)
                        }
                    }
                }
            });     
        });

        $('#reservationBody').on("click", ".checkout", function(e){
            var reservationdetailid = $(this).siblings('.reservationdetailid').val();
            $.ajax({
                url: '<?= yii\helpers\Url::toRoute("room-reservation/check-out") ?>',
                method: 'POST',
                dataType: 'json',
                data: {"reservationdetailid":reservationdetailid},
                success: function(result){
                    if (result == 1){
                        LoadReservation();
                    }else{
                        if (typeof(result) == "object"){
                            var errorMessage = "";
                            $(result).each(function(i, item){
                                for(var n in item){
                                    errorMessage += result[n].join(". ");
                                }
                            });

                            alert(errorMessage);
                        }else{
                            alert(result);
                        }
                    }
                },
                error: function(err){
                    alert(err.statusText);
                    if (typeof(err.responseJSON) != 'undefined'){
                        if (typeof(err.responseJSON.message) != 'undefined'){
                            console.log(err.responseJSON.message)
                        }
                    }
                }
            });     
        });     

        $('#reservationBody').on("click", ".extra", function(e){

        });
    }

    function LoadReservation(){
        $('#reservationBody').empty();
        $.ajax({
            url: '<?= yii\helpers\Url::toRoute("room-reservation/get-customer-reservations") ?>',
            method: 'POST',
            dataType: 'json',
            data: { 'customer':<?= $model->customerid ?> },
            success: function(result){
                $(result).each(function(i, item){
                    console.log(item);
                    var trObj = $('<tr/>');
                    trObj.append( $('<td/>').text( moment(item.start_date).format("DD-MMM'YY") ) );
                    trObj.append( $('<td/>').text( item.room ) );
                    trObj.append( $('<td/>').text( item.roomtype ) );
                    trObj.append( $('<td/>').text( item.checkin != null ? moment(item.checkin).format("DD-MMM'YY") : '' ) );
                    trObj.append( $('<td/>').text( item.checkout != null ? moment(item.checkout).format("DD-MMM'YY") : '' ) );

                    var extra = $('<a class="extra"><i class="fa fa-plus-circle"></i> Extra</a>');
                    var checkin = $('<a class="checkin"><i class="fa fa-arrow-circle-right"></i> Check In</a>');
                    var checkout = $('<a class="checkout"><i class="fa fa-arrow-circle-right"></i> Check Out</a>');
                    var cancel = $('<a class="cancel"><i class="fa fa-times-circle"></i> Cancel</a>');
                    var actionObj = $('<td/>').append(extra).append(' | ').append('<input class="reservationdetailid" type="hidden" value="'+item.reservationdetailid+'"/>').append(cancel).append(' | ');
                    if (item.checkin == null){
                        actionObj.append(checkin);
                    }else{
                        if (item.checkout == null){
                          actionObj.append(checkout);  
                        }
                    }
                    trObj.append( actionObj );
                    $('#reservationBody').append(trObj);
                });
            },
            error: function(err){
                alert(err.statusText);
                if (typeof(err.responseJSON) != 'undefined'){
                    if (typeof(err.responseJSON.message) != 'undefined'){
                        console.log(err.responseJSON.message)
                    }
                }
            }
        });
    }
</script>

<style type="text/css">
    .checkin, .checkout, .cancel, .extra{
        cursor: pointer;
    }
</style>
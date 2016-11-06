<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RoomReservationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Room Reservations';
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

            <div class="row">
                <div class="col-md-3">
                    <div style="margin-bottom:10px">
                        <select class="form-control" id="roomid">
                            <option></option>
                            <?php
                                $data = \app\models\Room::find()->orderBy('name')->all();
                                if (isset($data)){
                                    foreach ($data as $item) {
                                        echo '<option value='.$item->roomid.'>'.$item->name.'</option>';
                                    }
                                }
                            ?>
                        </select>
                    </div>

                    <div style="margin-bottom:10px">
                        <select class="form-control" id="roomtypeid">
                            <option></option>
                            <?php
                                $data = \app\models\RoomType::find()->orderBy('name')->all();
                                if (isset($data)){
                                    foreach ($data as $item) {
                                        echo '<option value='.$item->roomtypeid.'>'.$item->name.'</option>';
                                    }
                                }
                            ?>
                        </select>
                    </div>

                    <div style="margin-bottom:10px">
                    <select class="form-control" multiple="multiple" id="equipmentid">
                        <?php
                            $data = \app\models\Equipment::find()->orderBy('name')->all();
                            if (isset($data)){
                                foreach ($data as $item) {
                                    echo '<option value='.$item->equipmentid.'>'.$item->name.'</option>';
                                }
                            }
                        ?>
                    </select>
                    </div>

                    <div class="well well-sm" style="background-color:#fff;margin-bottom:10px;text-align:center;">
                        <div id="calendardate">
                        </div>
                    </div>

                    <div style="margin-bottom:10px">
                        <input type="button" value="Load" class="btn btn-danger" id="btnLoad"/>
                        <a class="btn btn-success" href="<?= yii\helpers\Url::toRoute("room-reservation/create-reservation") ?>">Reservasi Baru</a>
                    </div>
                </div>

                <div class="col-md-9" id="roomContainer">
                    
                </div>
            </div>

        </div>
    </div>
</section>


<script type="text/javascript">  
function Init(){
    $('#roomid').select2({
        placeholder: 'Select a room...',
        allowClear: true
    });

    $('#roomtypeid').select2({
        placeholder: 'Select a room type...',
        allowClear: true
    });

    $('#equipmentid').select2({
        placeholder: 'Select equipments...',
        multiple: true
    });

    var dp = $('#calendardate').datepicker({
        todayHighlight: true,
        todayBtn: "linked",
        format: 'dd-M-yyyy',
        defaultDate: true
    });

    dp.on("changeDate", function(e){
        $('#btnLoad').click();
    });

    $('#calendardate').datepicker('setDate', new Date());
    
    $('#btnLoad').click(function(e){
        $('#roomContainer').empty();
        $('#roomContainer').append('<img src="<?=\Yii::$app->request->BaseUrl?>/img/ajax-loader.gif"/>');
        $.ajax({
            url: '<?= yii\helpers\Url::toRoute("room-reservation/get-reservation-list") ?>',
            method: 'POST',
            dataType: 'json',
            data: {
                'date':moment($('#calendardate').datepicker('getDate')).format('YYYY-MM-DD'), 
                'room':$('#roomid').val(), 
                'roomtype':$('#roomtypeid').val(), 
                'equipments':$('#equipmentid').val()
            },
            success: function(result){
                $('#roomContainer').empty();
                var floors = $.unique($.map(result, function(item, i){
                    return item.floorid;
                }));

                $(floors).each(function(i, floor){
                    var rooms = $(result).filter(function(i, item){
                        return item.floorid == floor;
                    });

                    if (typeof(rooms) == 'undefined' || rooms == null)
                        return;

                    var container = $('<div/>').addClass('reservation-container');
                    container.append('<h4 class="header-tag">'+rooms[0].floor+'</h4>');
                    var row = $('<div class="row"/>');

                    $(rooms).each(function(j, room){
                        var innerDiv = $('<div class="inner"/>');
                        innerDiv.append('<div><span class="room-tag">'+room.room+'</span></div>');
                        innerDiv.append('<div><span class="room-type-tag">'+room.roomtype+'</span></div>');
                        if (room.customerid != null){
                            innerDiv.append('<div><a href="<?= yii\helpers\Url::toRoute("room-reservation/view") ?>?id='+room.customerid+'" class="customer-tag">'+(room.customer != null ? room.customer : '-')+'</a></div>');    
                        }else{
                            innerDiv.append('<div><a class="customer-tag">-</a></div>');
                        }
                        
                        var boxDiv = $('<div class="small-box"/>').css('background-color', room.statuscolor).append(innerDiv);

                        boxDiv.append($('<input class="roomid" type="hidden"/>').val(room.roomid));
                        boxDiv.append($('<input class="reservationdetailid" type="hidden"/>').val(room.reservationdetailid));
                        if (room.checkin == null){
                            boxDiv.append('<a class="small-box-footer checkin" style="font-size:12px;cursor:pointer">Check In <i class="fa fa-arrow-circle-right"></i></a>');    
                        }else{
                            boxDiv.append('<a class="small-box-footer checkout" style="font-size:12px;cursor:pointer">Check Out <i class="fa fa-arrow-circle-right"></i></a>');    
                        }
                        boxDiv.append('<a class="small-box-footer cancel" style="font-size:12px;cursor:pointer">Cancel <i class="fa fa-times-circle"></i></a>');    
                        row.append($('<div class="col-sm-2"/>').append(boxDiv));
                        //$('#roomContainer').append(room.roomstatus);
                    });
                    container.append(row);
                    $('#roomContainer').append(container);
                });
            },
            error: function(err){
                $('#roomContainer').empty();
                alert(err.statusText);
                if (typeof(err.responseJSON) != 'undefined'){
                    if (typeof(err.responseJSON.message) != 'undefined'){
                        console.log(err.responseJSON.message)
                    }
                }
            }
        });

    });

    $('#roomContainer').on("click", ".checkin", function(e){
        var reservationdetailid = $(this).siblings('.reservationdetailid').val();
        $.ajax({
            url: '<?= yii\helpers\Url::toRoute("room-reservation/check-in") ?>',
            method: 'POST',
            dataType: 'json',
            data: {"reservationdetailid":reservationdetailid},
            success: function(result){
                if (result == 1){
                    $('#btnLoad').click();
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

    $('#roomContainer').on("click", ".cancel", function(e){
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
                    $('#btnLoad').click();
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

    $('#roomContainer').on("click", ".checkout", function(e){
        var reservationdetailid = $(this).siblings('.reservationdetailid').val();
        $.ajax({
            url: '<?= yii\helpers\Url::toRoute("room-reservation/check-out") ?>',
            method: 'POST',
            dataType: 'json',
            data: {"reservationdetailid":reservationdetailid},
            success: function(result){
                if (result == 1){
                    $('#btnLoad').click();
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
}
</script>

<?php
    $this->registerJs("
        $( document ).ready(function() {
            Init();
            $('#btnLoad').click();
        });
    ", \yii\web\View::POS_END);
?>

<style>
    .hidden{
        display:none;
    }
    .reservation-container {
        margin-bottom: 10px;
    }
    .reservation-container .room-tag {
        font-size:18px;font-weight:bold;color:white;
    }
    .reservation-container .room-type-tag, .reservation-container .customer-tag {
        font-size:12px;color:white;
    }
    .reservation-container .header-tag {
        font-size: 15px;
    }
    .datepicker-inline{
        width: 100% !important
    }
</style>
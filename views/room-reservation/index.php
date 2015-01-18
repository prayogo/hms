<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\datecontrol\Module;
use kartik\datecontrol\DateControl;
use kartik\date\DatePicker;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RoomReservationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Room Reservations';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="room-reservation-index">

    <h1>
        <img height="50px" src="<?=\Yii::$app->request->BaseUrl?>/img/reservation.png"/>
        <span style="vertical-align: middle;"><?= Html::encode($this->title) ?></span></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Room Reservation', ['create'], ['class' => 'btn btn-success']) ?>
        <button type="button" class="btn btn-success" id="refresh-reservation"><i class="fa fa-refresh"></i> Load</button>
    </p>
<div class="row">
    <div class="col-md-3">
        

        <div style="margin-bottom:10px">
        <?php 
        $data = [];
        $data += yii\helpers\ArrayHelper::map(\app\models\Room::find()->asArray()->orderBy('name')->all(), 'roomid', 'name');
        echo Select2::widget([
            'id' => 'room-id', 
            'name' => 'Reservation[Room]',
            'data' => $data,
            'options' => [
                'placeholder' => 'Select a room...', 
            ],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
        ?>
        </div>

        <div style="margin-bottom:10px">
        <?php 
        $data = [];
        $data += yii\helpers\ArrayHelper::map(\app\models\RoomType::find()->asArray()->orderBy('name')->all(), 'roomtypeid', 'name');
        echo Select2::widget([
            'name' => 'Reservation[RoomType]',
            'id' => 'room-type-id', 
            'data' => $data,
            'options' => [
                'placeholder' => 'Select a room type...', 
            ],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
        ?>
        </div>

        <div style="margin-bottom:10px">
        <?php 
        $data = [];
        $data += yii\helpers\ArrayHelper::map(\app\models\Equipment::find()->asArray()->orderBy('name')->all(), 'equipmentid', 'name');
        echo Select2::widget([
            'name' => 'Reservation[Equipment]', 
            'id' => 'equipment-id', 
            'data' => $data,
            'options' => [
                'placeholder' => 'Select equipments...', 
                'multiple' => true
            ],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
        ?>
        </div>

        <div class="well well-sm" style="background-color:#fff;margin-bottom:10px;text-align:-webkit-center !important;text-align:center;">
        <?php
            date_default_timezone_set("Asia/Jakarta");
            echo DatePicker::widget([
                'name' => 'Reservation[Room]',
                'id' => 'date-text',
                'type' => DatePicker::TYPE_INLINE,
                'value' => date("D, d-M-Y"),
                'pluginOptions' => [
                    'format' => 'D, dd-M-yyyy',
                    'hideInput'=>1, 
                ],
                'pluginEvents' => [
                    'beforeShowDay' => 'function(e){ alert(1); }'
                ],
            ]);
        ?>
        </div>

    </div>
    <div class="col-md-9">
    <table class="table table-striped table-bordered" id="table-room" style="width:100%;">
      <thead>
        <tr><th colspan="7" class="text-center" id="header" style="background-color: rgb(239, 239, 239); font-size:16px">Sun, 14-Dec-2014</th></tr>
        <tr>
          <th class="text-left hidden">RoomId</th> 
          <th class="text-left">Room</th>
          <th class="text-left">Floor</th>
          <th class="text-left">Room Type</th>
          <th class="text-left">Rate</th>
          <th class="text-left hidden">ReservationId</th>
          <th class="text-left">Date</th>
          <th class="text-left"></th>
        </tr>
      </thead>
      <tbody>
        
      </tbody>
    </table>
    </div>
</div>
</div>
<?php

$this->registerJs("
    $('#refresh-reservation').click(function(){
        loadroom();
    });

    function loadroom(){
        var room = $('#room-id').val();
        var roomtype = $('#room-type-id').val();
        var equipments = $('#equipment-id').val();
        var date = $('#date-text').val();
        if (date == ''){
            date = '".date("D, d-M-Y")."'
        }
        
        $('#table-room tbody').empty();
        $('#table-room tbody').append('<tr id=\'loader\'><td colspan=7 class=text-center><img style=\'text-align:center\' width=\'30px\' src=\'".yii\helpers\BaseUrl::base()."/css/loading.gif\'></td></tr>');

        $.ajax({
            url: '".yii\helpers\Url::toRoute('room-reservation/reservation-list')."',
            method: 'POST',
            dataType: 'json',
            data: {'date':date, 'room':room, 'roomtype':roomtype, 'equipments':equipments},
            success: function(result){

                if ($('#date-text').val() == ''){
                    $('#header').html('".date("D, d-M-Y")."');
                }else{
                    $('#header').html($('#date-text').val());   
                }

                if(result.length > 0){

                    for(var i = 0; i < result.length; i++){
                        var roomid = result[i].roomid != null ? result[i].roomid : '-';
                        var room = result[i].name != null ? result[i].name : '-';
                        var floor = result[i].floor != null ? result[i].floor : '-';
                        var roomtype = result[i].roomtype != null ? result[i].roomtype : '-';
                        var rate = result[i].rate != null ? result[i].rate : '-';
                        var roomreservationid = result[i].roomreservationid != null ? result[i].roomreservationid : '';
                        var date = (result[i].startdate != null ? result[i].startdate : '') + ' - ';
                        date = date + (result[i].enddate != null ? result[i].enddate : '');

                        var style = 'background-color:'+result[i].color;
                        var action = '';
                        if (roomreservationid != ''){
                            action = '<a href=\'".yii\helpers\Url::toRoute('room-reservation/view')."?id='+roomreservationid+'\' title=View><span class=\'glyphicon glyphicon-eye-open\'></span></a>';
                        }


                        $('#table-room tbody').append('<tr><td class=hidden>'+roomid+'</td><td>'+room+' <span class=label style='+style+'>'+result[i].status+'</span></td><td>'+floor+'</td><td>'+roomtype+'</td><td>'+rate+'</td><td class=hidden>'+roomreservationid+'</td><td>'+date+'</td><td>'+action+'</td></tr>');

                    }
                } else{
                    $('#table-room tbody').append('<tr><td colspan=7>No results found.</td></tr>');

                }

                $('#loader').remove();
            }
        });
    }

    $( document ).ready(function() {
        loadroom();
    });


", \yii\web\View::POS_END);
?>

<style>
    .hidden{
        display:none;
    }
</style>
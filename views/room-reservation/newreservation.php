<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Reservasi Baru';
$this->params['breadcrumbs'][] = ['label' => 'Room Reservations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

\yii\web\jQueryAsset::register($this);
\app\assets\InputMaskAsset::register($this);
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

        <?php $form = ActiveForm::begin(['options'=>['class'=>'form-horizontal']]); ?>

        	<div class="form-group">
				<label class="col-sm-2 control-label">Pelanggan</label>
				<div class="col-sm-10">
				    <label class="radio-inline">
						<input type="radio" name="customerRadio" value="new" checked="checked"> Baru
					</label>
					<label class="radio-inline">
						<input type="radio" name="customerRadio" value="old"> Lama
					</label>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-10 col-sm-offset-1" style="margin-top:10px;">
					<div class="box box-solid" id="oldcustomerpanel" style="margin-bottom:10px">
						<div class="box-body highlight" style="padding-top:15px;margin-bottom:0px">
							<?php 

						    $sql = "select customerid, concat(name,' - ',address) as descr from ps_customer";  
					        $data = [];
					        $data += yii\helpers\ArrayHelper::map(\app\models\Customer::findBySql($sql)
					            ->asArray()
					            ->orderBy('name')
					            ->all(), 'customerid', 'descr');

						    echo $form->field($roomReservation, 'customerid', [
				                'labelOptions'=>['class'=>'col-sm-2 control-label'], 
				                'template' => '{label}<div class="col-sm-6">{input}{hint}{error}</div>'
				            ])->dropDownList($data)

						    ?>
						</div>
					</div>
					<div class="box box-solid" id="newcustomerpanel" style="margin-bottom:10px">
						<div class="box-body highlight" style="padding-top:15px; margin-bottom:0px">
							<?= $form->field($customer, 'name', [
					            'labelOptions'=>['class'=>'col-sm-2 control-label input-sm'], 
					            'template' => '{label}<div class="col-sm-6">{input}{hint}{error}</div>'
					        ])->textInput(['maxlength' => 50, 'class' => 'form-control input-sm']) ?>

					        <?= $form->field($customer, 'address', [
					            'labelOptions'=>['class'=>'col-sm-2 control-label input-sm'], 
					            'template' => '{label}<div class="col-sm-6">{input}{hint}{error}</div>'
					        ])->textArea(['maxlength' => 150, 'class' => 'form-control input-sm']) ?>

					        <?php 

						    $data = [];
						    $data += yii\helpers\ArrayHelper::map(\app\models\Location::find()->asArray()->orderBy('name')->all(), 'locationid', 'name');

						    echo $form->field($customer, 'locationid', [
				                'labelOptions'=>['class'=>'col-sm-2 control-label input-sm'], 
				                'template' => '{label}<div class="col-sm-6">{input}{hint}{error}</div>'
				            ])->dropDownList($data)

						    ?>

						    <?= $form->field($customerPhone, 'phone', [
					            'labelOptions'=>['class'=>'col-sm-2 control-label input-sm'], 
					            'template' => '{label}<div class="col-sm-6">{input}{hint}{error}</div>'
					        ])->textInput(['maxlength' => 15, 'class' => 'form-control input-sm']) ?>

					        <?php 

						    $data = [];
						    $data += yii\helpers\ArrayHelper::map(\app\models\IdentificationType::find()->asArray()->orderBy('name')->all(), 
						    	'identificationtypeid', 'name');

							$ddl = Html::activeDropDownList($customerIdentification, 'identificationtypeid', $data, [
								'class'=>'form-control input-sm'
							]);

							?>

					        <?= $form->field($customerIdentification, 'identificationno', [
					            'labelOptions'=>['class'=>'col-sm-2 control-label input-sm'], 
					            'template' => '{label}<div class="col-sm-6"><div><div class="horizontal-inline col-4">'.$ddl.'</div><div class="horizontal-inline col-8">{input}</div></div>{hint}{error}</div>'
					        ])->textInput(['maxlength' => 25, 'class' => 'form-control input-sm']) ?>
						</div>
					</div>
				</div>
			</div>

	        <div class="form-group">
				<label class="col-sm-2 control-label">Pilih Kamar</label>
				<div class="col-sm-12">

        			<div class="box box-solid" id="" style="margin-bottom:20px">
						<div class="box-body highlight" style="padding-top:15px;margin-bottom:0px; margin-top:10px">
							<a id="btnLoadMore" style="cursor:pointer;user-select:none;-webkit-user-select: none;"><i class="fa fa-plus-circle"></i> Tambah Tanggal</a>
							<a id="btnDeleteAll" style="margin-left:5px;cursor:pointer;user-select:none;-webkit-user-select: none;"><i class="fa fa-plus-circle"></i> Hapus Semua</a>
							
<div style="position:relative; background-color:white;margin-top:5px">
	<div class="table-wrapper">
		<table class="table table-striped table-bordered table-condensed" style="table-layout:fixed; margin-bottom:10px; width:auto">
			<thead id="headercontainer">
				<tr>
					<th class="freeze" style="width:100px;top:0px;border-top:1px solid #ddd;border-bottom: 1px solid #ddd;">Kamar</th>
					<th class="freeze" style="width:100px;top:0px;border-top:1px solid #ddd;border-bottom: 1px solid #ddd;left:99px;">Tipe Kamar</th>
					<!-- Add new header -->
				</tr>
			</thead>
			<tbody id="bodycontainer">
				<!-- Add row -->
			</tbody>
		</table>
	</div>
</div>

						</div>
					</div>
				</div>
	        </div>

	        <div class="form-group">
				<label class="col-sm-2 control-label">Ringkasan</label>
				<div class="col-sm-8">
					<table class="table table-striped table-bordered table-condensed">
						<thead>
							<tr>
								<th>Kamar</th>
								<th>Tipe</th>
								<th>Harga</th>
								<th>Hari</th>
								<th>Tanggal</th>
							</tr>
						</thead>
						<tbody id="summaryTable">
							
						</tbody>
						<tfoot>
							<tr>
								<th colspan="2">Total</th>
								<th colspan="3"><span id="grandTotal">0</span></th>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label">Deposit</label>
				<div class="col-sm-6">
					<input type="text" id="deposit" class="form-control" data-mask='000.000.000.000.000' data-mask-reverse='true'>
					<div class="help-block"></div>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-12 col-sm-offset-2">
					<input type="submit" class="btn btn-success" value="Simpan" />
				</div>
			</div>


        <?php ActiveForm::end(); ?>

			

        </div>
    </div>
</section>

<script>

var roomData;

function AdjustHeight(){
	$('.table-wrapper tr').each(function () {
		var tr = $(this), h = 0;
		tr.children().each(function () {
			var td = $(this), tdh = td.height();
			if (tdh > h) h = tdh;
		});
		tr.css({height: (h + 10) + 'px'});
		tr.children().css({height: (h + 10.5) + 'px'});
	});
}

function LoadHeader(){
	$.ajax({
        url: '<?= yii\helpers\Url::toRoute("room-reservation/get-room-list") ?>',
        method: 'POST',
        dataType: 'json',
        success: function(result){
            //$('#bodycontainer').empty();
			roomData = result;
            var headerWith = 100;
			$(result).each(function(i, item){
				var leftPad = 0;
				var tr = $('<tr/>');
				var roomid = $('<input type="hidden" class="roomid" />').val(item.roomid);
				tr.append($('<th/>').addClass('freeze').css('width', headerWith + 'px').html(item.room).append(roomid));
				tr.append($('<th/>').addClass('freeze').css('width', headerWith + 'px').css('left', (leftPad+=headerWith-1) + 'px').html(item.roomtype));
				$('.table-wrapper').css('margin-left', (leftPad+=headerWith-1) + 'px');
				$('#bodycontainer').append(tr);
			});
			
			AdjustHeight();
			LoadDetail();
			SetFunction();
        },
        error: function(err){
            $('#bodycontainer').empty();
            alert(err.statusText);
            if (typeof(err.responseJSON) != 'undefined'){
                if (typeof(err.responseJSON.message) != 'undefined'){
                    console.log(err.responseJSON.message)
                }
            }
        }
    });
}

function AddColumn(date){
	var varText = moment(date).format("DD-MMM'YY");
    var thObj = $('<th/>').css('min-width', '75px').text(varText);
	$('#headercontainer tr').append(thObj);

	var tdObj = $('<td/>').addClass('select').css('min-width', '70px');

	var tdDate = $('<input type="hidden" class="date"/>').val( moment(date).format("DD-MM-YYYY") );
	tdObj.append(tdDate);

	$('#bodycontainer tr').append(tdObj);


	$.ajax({
        url: '<?= yii\helpers\Url::toRoute("room-reservation/room-rate-by-date") ?>',
        method: 'POST',
        dataType: 'json',
        data: {"date": moment(date).format('DD-MM-YYYY')},
        success: function(result){
        	$(result).each(function(i, item){
        		var row = $('#bodycontainer tr').find('.roomid[value='+item.roomid+']').closest('tr');
        		var cell = $(row).find('.date[value="'+item.date+'"]').closest('.select ');

				//rate
				var rate = item.rate - item.roomdiscount - item.roomtypediscount;
				var objPriceSpan = $('<span class="room-price"/>').text( rate.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,') );
				cell.append(objPriceSpan);

				var objPrice = $('<input type="hidden" class="price"/>').val(rate);
				cell.append(objPrice);

				//if available then 
				if (item.book == 1){
					cell.append('<input type="hidden" class="book"/>');
				}else{
					cell.css('background-color', item.color);
				}
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

var start = new Date();
function LoadDetail(){
	var perLoad = 10;
	for(var i = 0; i < perLoad; i++){
		AddColumn(start);
		start.setDate(start.getDate() + 1);
	}
}

function SetFunction(){
	$('#btnLoadMore').click(function(e){
		LoadDetail();
	});
	
	$('table').on('click', '.select', function () {
		var flag = $(this).find('.book');
		if (typeof(flag) != 'undefined' && flag.length > 0){
			if (flag.val() == 1){
				flag.val(0);
				$(this).css('background','none');
			}else{
				flag.val(1);
				$(this).css('background','green');
			}
		}else{
			//$(this).css('background','none');
		}
	});
}

function GetAllBooking(){
	var bookItems = $('.book[value=1]');
	$(bookItems).each(function(i, item){
		var roomid = $(item).closest('tr').find('.roomid').val();
		var date = $(item).siblings('.date').val();
		console.log(roomid);
		console.log(date);
	});
}

function ReservationSummary(){
	$('#summaryTable').empty();
	$('#grandTotal').val(0);
	var grandTotal = 0;

	$('#bodycontainer tr').each(function(i, item){
		var roomid = $(item).find('.roomid').val();
		var books = $(item).find('.book[value=1]').length;

		if (books > 0){
			var room = $.grep(roomData, function(n, i){
			  	return n.roomid == roomid;
			});

			var date = $(item).find('.book[value=1]').siblings('.date');
			
			var tdObj = $('<td/>');
			$(date).each(function(j, n){
				var dateSpan = $('<span class="label label-success"/>').text(moment($(n).val(), "DD-MM-YYYY").format("DD-MMM'YY"));
				tdObj.append(dateSpan).append(' ');
			});

			var price = $(item).find('.book[value=1]').siblings('.price');
			var total = 0;
			$(price).each(function(j, n){
				total += Number($(n).val());
			});

			var tr = $('<tr/>');
			tr.append($('<td/>').text(room[0].room));
			tr.append($('<td/>').text(room[0].roomtype));
			tr.append($('<td/>').text( total.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,') ));
			tr.append($('<td/>').text(books));

			tr.append($('<td/>').append( tdObj ));
			$('#summaryTable').append(tr);
			grandTotal += total;
		}
		$('#grandTotal').text( grandTotal.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,') );
	});
}

function Init(){
	$('#customer-locationid').val('IDN');
	$('select').select2();

	$('input[name="customerRadio"]').change(function(e){
		ValidateCustomer();
	});

	$('#bodycontainer').on("click", "td.select", function(e){
		setTimeout(function(){ ReservationSummary(); }, 100);
	});

	$('#btnDeleteAll').click(function(e){
		var books = $('#bodycontainer tr').find('.book[value=1]');
		$(books).each(function(i, item){
			$(item).val(0);
			$(item).closest('.select').css('background','none');;
		});
		ReservationSummary();
	});

	$('#w0').on("beforeSubmit", function(e){
		var books = $('#bodycontainer tr').find('.book[value=1]').length;
		if (books < 1){
			alert('Pilih kamar terlebih dahulu!');
			return false;
		}

		var selected = $('input[name="customerRadio"]:checked').val();
		var customerid = 0;
		var customername = '';
		var customeraddress = '';
		var customerphone = '';
		var customeridentificationtype = '';
		var customeridentificationno = '';
		var customerlocation = '';
		var deposit = $('#deposit').val();

		if (selected == "new"){
			customername = $('#customer-name').val();
			customeraddress = $('#customer-address').val();
			customerphone = $('#customerphone-phone').val();
			customerlocation = $('#customer-locationid').val();
			customeridentificationtype = $('#customeridentification-identificationtypeid').val();
			customeridentificationno = $('#customeridentification-identificationno').val();
		}else {
			customerid = $('#roomreservation-customerid').val();
		}

		var reservation = [];
		$('#bodycontainer tr').each(function(i, item){
			var roomid = $(item).find('.roomid').val();
			var books = $(item).find('.book[value=1]').length;

			if (books > 0){
				var date = $(item).find('.book[value=1]').siblings('.date');
				$(date).each(function(j, item){
					reservation.push({"roomid": roomid, "date": $(item).val() });
				});
			}
		});
		
		var postData = {
			"customerid":customerid,
			"customername":customername,
			"customeraddress":customeraddress,
			"customerlocation":customerlocation,
			"customerphone":customerphone,
			"customeridentificationtype":customeridentificationtype,
			"customeridentificationno":customeridentificationno,
			"reservation":reservation,
			"deposit":deposit
		};

		$.ajax({
	        url: '<?= yii\helpers\Url::toRoute("room-reservation/create-new-reservation") ?>',
	        method: 'POST',
	        dataType: 'json',
	        data: postData,
	        success: function(result){
	        	if (result == 1){
	        		window.location = '<?= yii\helpers\Url::toRoute("room-reservation/") ?>';
	        	}else{
	        		if (typeof(result) == "object"){
	        			var errorMessage = "";
	        			$(result).each(function(i, item){
							for(var n in item){
								errorMessage += result[n].join(". ");
							}
	        			});

	        			alert(errorMessage);
	        		} else{
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
		return false;
	});
}

function ValidateCustomer(){
	var selected = $('input[name="customerRadio"]:checked').val();
	if (selected == "new"){
		if ($('#customer-name').val() == 'name123'){
			$('#customer-name').val('');	
		}
		$('#newcustomerpanel').show();
		$('#oldcustomerpanel').hide();
	}else {
		if ($('#customer-name').val() == ''){
			$('#customer-name').val('name123');	
		}
		$('#oldcustomerpanel').show();
		$('#newcustomerpanel').hide();
	}
}

</script>

<?php
    $this->registerJs("
        $( document ).ready(function() {
            LoadHeader();
            $('#btnLoad').click();
            Init();
            ValidateCustomer();
        });
    ", \yii\web\View::POS_END);
?>

<style>
.table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
    border: 1px solid #ddd !important;
}
.table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
    border-bottom-width: 2px !important;
}
.table-wrapper { 
    overflow-x:scroll;
    overflow-y:visible;
}
th.freeze {
    position: absolute;
    left: 0px;
}
thead > tr > th.freeze {
    height: auto !important;
}
tbody > tr > th.freeze {
    
}
.right-3{
	margin-right: 3px;
}
.select, .book {
	cursor:pointer;
}
.form-horizontal .form-group{
	margin-bottom: 0px
}
.horizontal-inline{
	float: left;
    margin-bottom: 10px;
    padding-right: 10px;
}
.col-4{
	width: 30%;
}
.col-8{
	width: 60%;
}
.highlight{
	padding: 9px 14px;
    margin-bottom: 14px;
    background-color: #f7f7f9;
    border: 1px solid #e1e1e8;
    border-radius: 4px;
}
.room-price{
	font-size: 11px
}
</style>
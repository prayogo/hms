<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PaymentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Payments';
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
            <form class="form-horizontal">
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Pelanggan</label>
                    <div class="col-sm-6">
                        <select class="form-control" id="customerid">
                            <option></option>
                            <?php
                                $data = \app\models\Customer::findBySql('select * from ps_customer
                                    where customerid in (
                                        select distinct a.customerid from ps_roomreservation a
                                        join ps_roomreservationdetail b on a.reservationid = b.reservationid
                                        where b.cancel = 0 and b.reservationdetailid not in (
                                            select reservationdetailid from ps_reservationpayment
                                        ) order by name
                                    )')->all();
                                if (isset($data)){
                                    foreach ($data as $item) {
                                        echo '<option value='.$item->customerid.'>'.$item->name.'</option>';
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div>
                        <button type="button" class="btn btn-danger" id="btnLoadPayment">Cari</button>
                    </div>
                </div>
            </form>

            <label>Reservasi</label>
            <table class="table table-striped table-bordered table-condensed" style="margin-bottom:10px">
                <thead>
                    <tr>
                        <th style="text-align:center"><input type="checkbox" id="reservationCheckAll"/></th>
                        <th>Pelanggan</th>
                        <th>Tanggal</th>
                        <th>Tipe</th>
                        <th>Kamar</th>
                        <th>Harga</th>
                        <th>Tanggal Reservasi</th>
                    </tr>
                </thead>
                <tbody id="paymentBody">
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>

            <label>Deposit</label>
            <table class="table table-striped table-bordered table-condensed" style="margin-bottom:10px">
                <thead>
                    <tr>
                        <th style="text-align:center"><input type="checkbox" id="depositCheckAll"/></th>
                        <th>Pelanggan</th>
                        <th>Tanggal</th>
                        <th>Deposit</th>
                    </tr>
                </thead>
                <tbody id="depositBody">
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <?php
        $hotel = \app\models\Hotel::find()->orderBy('hotelid desc')->one();
        $tax = \app\models\Tax::find()->orderBy('taxid desc')->one();
    ?>

    <div style="position: relative;background: #fff;border: 1px solid #f4f4f4;padding: 20px;">
              <!-- title row -->

      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
          From
          <address>
            <strong><?= $hotel->name ?></strong><br>
            <?= $hotel->address ?><br>
            <?= $hotel->city.', '.$hotel->location->name ?><br>
            <?php
                if ($hotel->phone1 != null && $hotel->phone1 != '')
                    echo 'Phone: '.$hotel->phone1.'<br>';
            ?>
            <?php
                if ($hotel->email != null && $hotel->email != '')
                    echo 'Email: '.$hotel->email.'<br>';
            ?>
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          To
          <address>
            <strong><span id="customername"></span></strong><br>
            <span id="customeraddr"></span><br>
            <span id="customerphone"></span>
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          <b>Clerk:</b> 4F3S8J<br>
          <b>Date:</b> <span id="printdate"></span>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="table table-striped table-condensed">
            <thead>
            <tr>
              <th>Room</th>
              <th>Extra Services</th>
              <th>Qty</th>
              <th colspan="2">Subtotal</th>
            </tr>
            </thead>
            <tbody id="paymentsummarydetail">

            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" style="text-align:right">Subtotal</th>
                    <th style="width:15px"><?= $tax->currency ?></th>
                    <th style="text-align:right"><span id="subtotal"></span></th>
                </tr>
                <tr>
                    <th colspan="3" style="text-align:right">Discounts</th>
                    <th style="width:15px"><?= $tax->currency ?></th>
                    <th style="text-align:right"><span id="discount"></span></th>
                </tr>
                <tr>
                    <th colspan="3" style="text-align:right">Deposit</th>
                    <th style="width:15px"><?= $tax->currency ?></th>
                    <th style="text-align:right"><span id="deposit"></span></th>
                </tr>
                <?php if ($tax->room != null && $tax->room > 0){ ?>
                        <tr>
                            <th colspan="3" style="text-align:right">Room Tax (<?= $tax->room ?>%)</th>
                            <th style="width:15px"><?= $tax->currency ?></th>
                            <th style="text-align:right"><span id="tax"></span></th>
                        </tr>
                <?php } ?>
                
                <tr>
                    <th colspan="3" style="text-align:right">Total</th>
                    <th style="width:15px"><?= $tax->currency ?></th>
                    <th style="text-align:right"><span id="grandtotal"></span></th>
                </tr>
            </tfoot>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- this row will not appear when printing -->
      <div class="row no-print">
        <div class="col-xs-12">
            <button id="btnSubmitPayment" type="button" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Konfirmasi Pembayaran</button>
        </div>
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
        $('#customerid').select2({
            placeholder: 'Select a room type...',
            allowClear: true
        });

        $('#btnLoadPayment').click(function(e){
            $('#reservationCheckAll').prop('checked', false);
            $('.reservepay').prop('checked', false);
            $('#depositCheckAll').prop('checked', false);
            $('.depositpay').prop('checked', false);
            LoadPaymentList();
            LoadPayment();
        });

        $('#paymentBody').on('click', '.reservepay', function(e){
            LoadPayment();
        });

        $('#depositBody').on('click', '.depositpay', function(e){
            LoadPayment();
        });

        $('#btnSubmitPayment').click(function(e){
            var selected = $('.reservepay:checked');
            var reservations = $.map(selected, function(i, n){
                return $(i).siblings('.reservationdetailid').val();
            });

            var selected = $('.depositpay:checked');
            var deposits = $.map(selected, function(i, n){
                return $(i).siblings('.depositid').val();
            });

            $.ajax({
                url: '<?= yii\helpers\Url::toRoute("payment/submit-payment") ?>',
                method: 'POST',
                dataType: 'json',
                data: { 'reservations':reservations, 'deposits':deposits },
                success: function(result){
                    if (result == 1){
                        alert('Save');
                    }else{
                        alert(result);
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

        $('#reservationCheckAll').click(function(e){
            if ($('#reservationCheckAll').prop('checked')){
                $('.reservepay').prop('checked', 'checked');
            }else{
                $('.reservepay').prop('checked', false);
            }
            LoadPayment();
        });

        $('#depositCheckAll').click(function(e){
            if ($('#depositCheckAll').prop('checked')){
                $('.depositpay').prop('checked', 'checked');
            }else{
                $('.depositpay').prop('checked', false);
            }
            LoadPayment();
        });
    }

    function LoadPayment(){
        var selected = $('.reservepay:checked');
        var reservations = $.map(selected, function(i, n){
            return $(i).siblings('.reservationdetailid').val();
        });

        var selected = $('.depositpay:checked');
        var deposits = $.map(selected, function(i, n){
            return $(i).siblings('.depositid').val();
        });

        $('#paymentsummarydetail').empty();
        $('#customername').text('');
        $('#customeraddr').text('');
        $('#customerphone').text('');
        $('#printdate').text('');
        $('#grandtotal').text(0.00);
        $('#tax').text(0.00);
        $('#subtotal').text(0.00);
        $('#deposit').text(0.00);
        $('#discount').text(0.00);

        $.ajax({
            url: '<?= yii\helpers\Url::toRoute("payment/get-payment-summary") ?>',
            method: 'POST',
            dataType: 'json',
            data: { 'reservations':reservations, 'deposits':deposits },
            success: function(result){
                if(result == null){
                    //alert('Reservasi tidak ditemukan.');
                }else{
                    var discount = 0;
                    var tax = 0;
                    var subtotal = 0;
                    var grandtotal = 0;

                    $(result).each(function(i, item){
                        grandtotal += Number(item.rate);
                        var trObj = $('<tr/>');
                        trObj.append( $('<td/>').text(item.roomtype + '@' + item.room).attr('rowspan', item.extras.length + 1) );
                        trObj.append( $('<td/>') );
                        trObj.append( $('<td/>').text(item.days) );
                        trObj.append( $('<td colspan="2"/>').text(Number(item.rate).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,') ).css('text-align', 'right') );
                        subtotal += Number(item.rate);
                        $('#paymentsummarydetail').append(trObj);

                        $(item.extras).each(function(j, extra){
                            $(extra.details).each(function(j, detail){
                                var extraTr = $('<tr/>');
                                subtotal += Number(detail.subtotal);
                                extraTr.append( $('<td/>').append(detail.service) );
                                extraTr.append( $('<td/>').append(detail.qty) );
                                extraTr.append( $('<td/>').append( Number(detail.subtotal).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,') ).css('text-align', 'right') );
                                $('#paymentsummarydetail').append(extraTr);    
                                grandtotal += Number(detail.subtotal);
                            });
                        });

                        discount += Number(item.discount);
                        tax += Number(item.tax);
                    });

                    if (result.length > 0){
                        $('#customername').text(result[0].customername);
                        $('#customeraddr').text(result[0].customeraddr);
                        $('#customerphone').text(result[0].customerphone);

                        $('#printdate').text(result[0].date);
                        if (Number(result[0].deposit) > 0){
                            $('#deposit').text( '-'+Number(result[0].deposit).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,') );
                            grandtotal -= Number(result[0].deposit);
                        }else{
                            $('#deposit').text( 0.00 );
                        }

                        $('#subtotal').text( subtotal.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,') );
                        if (discount > 0){
                            $('#discount').text( '-'+discount.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,') );
                        }else{
                            $('#discount').text(0.00);
                        }
                        if (tax > 0){
                            $('#tax').text( tax.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,') );
                        }else{
                            $('#tax').text(0.00);
                        }

                        grandtotal += tax;
                        grandtotal -= discount;
                        $('#grandtotal').text( grandtotal.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,') );
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
    }

    function LoadPaymentList(){
        var customer = $('#customerid').val();
        $.ajax({
            url: '<?= yii\helpers\Url::toRoute("payment/get-payment-list") ?>',
            method: 'POST',
            dataType: 'json',
            data: { 'customer':customer },
            success: function(result){
                $('#paymentBody').empty();
                if (result != null){
                    if (result.length < 1){
                        $('#paymentBody').append('<tr><td colspan="6" style="text-align:center">Tidak ada data</td></tr>');
                    }else{
                        $(result).each(function(i, item){
                            var trObj = $('<tr/>');
                            var tdObj = $('<td style="text-align:center"/>');
                            tdObj.append('<input type="checkbox" class="reservepay"/>');
                            tdObj.append( $('<input class="reservationdetailid" type="hidden"/>').val(item.reservationdetailid) );
                            trObj.append( tdObj );
                            trObj.append($('<td/>').text(item.customer));
                            trObj.append($('<td/>').text( moment(item.start_date).format("DD-MMM'YY") ));
                            trObj.append($('<td/>').text(item.roomtype));
                            trObj.append($('<td/>').text(item.room));
                            trObj.append($('<td/>').text( Number(item.rate).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,') ));
                            trObj.append($('<td/>').text( moment(item.reservedate).format("DD-MMM'YY HH:mm") ));
                            $('#paymentBody').append(trObj);
                        });

                        $('#btnPay').show();
                    }
                }else{
                    $('#paymentBody').append('<tr><td colspan="6" style="text-align:center">Tidak ada data</td></tr>');
                    $('#btnPay').hide();
                }
            },
            error: function(err){
                $('#paymentBody').empty();
                alert(err.statusText);
                if (typeof(err.responseJSON) != 'undefined'){
                    if (typeof(err.responseJSON.message) != 'undefined'){
                        console.log(err.responseJSON.message)
                    }
                }
            }
        });

        $.ajax({
            url: '<?= yii\helpers\Url::toRoute("payment/get-deposit-list") ?>',
            method: 'POST',
            dataType: 'json',
            data: { 'customer':customer },
            success: function(result){
                $('#depositBody').empty();
                if (result != null){
                    if (result.length < 1){
                        $('#depositBody').append('<tr><td colspan="4" style="text-align:center">Tidak ada data</td></tr>');
                    }else{
                        $(result).each(function(i, item){
                            var trObj = $('<tr/>');
                            var tdObj = $('<td style="text-align:center"/>');
                            tdObj.append('<input type="checkbox" class="depositpay"/>');
                            tdObj.append( $('<input class="depositid" type="hidden"/>').val(item.depositid) );
                            trObj.append( tdObj );
                            trObj.append($('<td/>').text(item.customer));
                            trObj.append($('<td/>').text( moment(item.date).format("DD-MMM'YY") ));
                            trObj.append($('<td/>').text( Number(item.rate).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,') ));
                            $('#depositBody').append(trObj);
                        });
                    }
                }else{
                    $('#depositBody').append('<tr><td colspan="4" style="text-align:center">Tidak ada data</td></tr>');
                }
            },
            error: function(err){
                $('#depositBody').empty();
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
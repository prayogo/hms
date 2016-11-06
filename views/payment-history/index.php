<?php

use yii\helpers\Html;

$this->title = 'History Pembayaran';
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
                    <label class="col-sm-2 control-label">Pelanggan</label>
                    <div class="col-sm-5">
                        <select class="form-control" id="customerid">
                            <option></option>
                            <?php
                                $data = \app\models\Customer::findBySql('select * from ps_customer
                                    where customerid in (
                                        select distinct customerid from ps_payment
                                    )')->all();
                                if (isset($data)){
                                    foreach ($data as $item) {
                                        echo '<option value='.$item->customerid.'>'.$item->name.'</option>';
                                    }
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Tanggal</label>
                    <div class="col-sm-5">
                    	<div class="input-group">
							<input type="text" class="form-control" id="startdate">
							<div class="input-group-addon"></div>
							<input type="text" class="form-control" id="enddate">
						</div>
                    </div>
                    <div>
                        <button type="button" class="btn btn-danger" id="btnLoadPayment">Cari</button>
                    </div>
                </div>
            </form>

            <table class="table table-striped">
            	<thead>
            		<tr>
            			<th>Customer</th>
            			<th>Tanggal</th>
            			<th></th>
            		</tr>
            	</thead>
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
       	var dp = $('#startdate').datepicker({
	        todayHighlight: true,
	        todayBtn: "linked",
	        format: 'dd-M-yyyy',
	        autoclose:true
	    });

	    var dp1 = $('#enddate').datepicker({
	        todayHighlight: true,
	        todayBtn: "linked",
	        format: 'dd-M-yyyy',
	        autoclose: true
	    });

	    $('#btnLoadPayment').click(function(e){
	    	var customerid = $('#customerid').val();
			var startdate = $('#startdate').val();
			var enddate = $('#enddate').val();

			if (moment(startdate, "DD-MMM-YYYY").format("DD-MM-YYYY") == "Invalid date"){
				$('#startdate').val('');
			}

			if (moment(enddate, "DD-MMM-YYYY").format("DD-MM-YYYY") == "Invalid date"){
				$('#enddate').val('');
			}

			if (customerid == ""){
				alert("Isi pelanggan terlebih dahulu.");
				return;
			}
			
	    	tableAjax.ajax.reload();
	    });

	    tableAjax = $('table').DataTable({
			'ajax': {
				'url': '<?= yii\helpers\Url::toRoute("payment-history/get-payment-history") ?>',
				'type': 'POST',
				'data': function ( d ) {
					return $.extend( {}, d, {
						'customerid': $('#customerid').val(),
						'startdate': $('#startdate').val(),
						'enddate': $('#enddate').val()
					} );
				}
			},
			'columns': [
				{ data: 'customer' },
				{ data: 'date' }
			],
			"columnDefs": [
	            {
	                "render": function ( data, type, row ) {
	                    return "<a style='cursor:pointer' href='<?= yii\helpers\Url::toRoute('payment-history/view') ?>?id="+row.paymentid+"'><i class='fa fa-eye'></i> Detail</a>";
	                },
	                "targets": 2
	            }
	        ]
		});
	}

	var tableAjax;
</script>
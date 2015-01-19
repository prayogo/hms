<html>
<head>
	<link href="<?= yii\helpers\BaseUrl::base();  ?>/css/bootstrap.css" rel="stylesheet">
</head>
<?php
	$hotel = \app\models\Hotel::find()->orderBy('hotelid desc')->one();
	$tax = \app\models\Tax::find()->orderBy('taxid desc')->one();
	$payment = \app\models\Payment::find()->where(['paymentid'=>$paymentid])->one();
?>
<style>
	.table > tbody > tr > td{
		border:none !important;
	}
</style>
<body style="width:980px; margin:0 auto;font-family: 'Cambria';">
<table>
<thead>
<tr>
	<td>
		<div style="float:left; margin-right:10px; padding-top:6px;border-right: 1px solid #E5E5E5;padding-right: 10px;height: 93px;">
			<img src="<?=\Yii::$app->request->BaseUrl?>/img/logo.png" height="80px">
		</div>
		<div style="font-size:16px; margin-bottom:20px;">
			<div>
				<span style="font-size: 26px !important;color: RGB(192,0,0) !important;">H </span> 
				<span style="color: RGB(192,0,0) !important;font-size: 22px !important;" id="otel"> O T E L &nbsp;</span>   
				<span style="font-size: 26px !important;color: RGB(0,112,192) !important;"> D </span> 
				<span style="color: RGB(0,112,192) !important;font-size: 22px !important;"> Y V A</span>
			</div>
			<div>
				E-mail: <?= $hotel->email ?>
			</div>
			<div>
				Tel: <?= $hotel->phone1 . ($hotel->phone2 == '' ? '' : ' / ' . $hotel->phone2) ?>
				<span style="margin-left:12px">Fax: <?= $hotel->fax ?></span>
			</div>
			<div>
				<?= $hotel->address . ', ' . $hotel->city . ', ' . $hotel->state . ', ' . $hotel->location->name ?>
			</div>
		</div>
	</td>
</tr>
</thead>
<tbody>
<tr>
	<td height="1150px" style="vertical-align:top">
	<div style="font-size:18px; height:140px; clear:both">
		<div style="width:480px; float:left">
			<div style="font-weight:bold">Informasi Tamu /<br> <i>Guest Information</i></div><br>
			<div style="font-weight:bold"><?= $payment->customer->name ?></div>
			<?php
				$latest_phone = '';
				foreach($payment->customer->customerphones as $phone){
					$latest_phone = $phone->phone;
				}
			?>
			<div style="font-weight:bold">Tel: <?= $latest_phone ?></div>
		</div>
		<?php
			
			$checkin = date('d/m/Y');
			$checkout = date('d/m/Y');
			foreach($payment->roomreservations as $room){

				if ($checkin > $room->startdate){
					$checkin = date('d/m/Y', strtotime($room->startdate));
				}

				if ($checkout < $room->enddate){
					$checkout = date('d/m/Y', strtotime($room->enddate));
				}
			}

		?>
		<div style="width:480px; float:left">
			<br>
			<div style="font-weight:bold"><span style="width:200px; display:inline-block">Check in</span>: 
				<?= $checkin ?>
			</div>
			<div style="font-weight:bold"><span style="width:200px; display:inline-block">Check out</span>: 
				<?= $checkout ?>
			</div>
			<div style="font-weight:bold"><span style="width:200px; display:inline-block">Tanggal / <i>Date</i></span>: 
				<?= date('d/m/Y', strtotime($payment->date)); ?>
			</div>
		</div>
	</div>

	<div>
		<table class="table table" style="font-size:18px !important;">
			<thead style="border-top:2px solid #ddd">
				<th class="text-center">Tanggal<br><i>Date</i></th>
				<th class="text-center" style="vertical-align: middle;">Service<br></th>
				<th class="text-center" style="vertical-align: middle;" colspan = 2>Debit<br></th>
				<th class="text-center" style="vertical-align: middle;" colspan = 2>Credit<br></th>
			</thead>
			<tbody>
				<?php
				$subtotal = 0;
				$charge = 0;
				$strextra = '';
					foreach($payment->roomreservations as $room){
						echo '<tr>';
						echo '<td>'.date('d.m.Y', strtotime($room->startdate)). ' - ' .date('d.m.Y', strtotime($room->enddate)).'</td>';

						$chargeStr = '';
				        $chargeStr = 'Adult@'.$room->adult.'-'.$room->room->roomtype->maxadult;
				        $chargeStr = $chargeStr.', Child@'.$room->child.'-'.$room->room->roomtype->maxchild;

						echo '<td>Akomodasi '.$room->room->name.' - ' . $room->room->roomtype->name . ' ('.$chargeStr . ') </td>';
						$date = $room->startdate;
				        $debit = 0;
				        while (strtotime($date) < strtotime($room->enddate)) {
				            $day = date("w", strtotime($date));
				            if ($day == '6' || $day == '7'){
				                $debit = $debit + $room->roomreservationrate->rate + $room->roomreservationrate->rate * $room->roomreservationrate->weekendrate;
				            }else{
				                $debit = $debit + $room->roomreservationrate->rate;
				            }
				            $date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));

				            if ($room->adult > $room->room->roomtype->maxadult){
					            $charge += ($room->adult - $room->room->roomtype->maxadult) * $room->room->roomtype->adultcharge;
					        }
					        if ($room->child > $room->room->roomtype->maxchild){
					            $charge += ($room->child - $room->room->roomtype->maxchild) * $room->room->roomtype->childcharge;
					        }

				        }
				        echo '<td>'.$tax->currency.'</td>';
						echo '<td class="text-right">'.number_format($debit).'</td>';
						echo '<td></td><td></td>';
						echo '</tr>';

						$subtotal = $subtotal + $debit;

						foreach($room->extraservices as $extra){
							$strextra = $strextra . '<tr>';
				            $strextra = $strextra . '<td>' . date('d.m.Y, H:i', strtotime($extra->date)) . '</td>';
				            $strextra = $strextra . '<td>' . $extra->serviceitem->name . ' @' . $extra->quantity . '</td>';
				            $strextra = $strextra . '<td>' . $tax->currency;
				            $strextra = $strextra . '<td class="text-right">' . number_format($extra->serviceitem->rate * $extra->quantity) . '</td>';
				            $strextra = $strextra . '<td></td><td></td>';
				            $strextra = $strextra . '</tr>';
				            $subtotal = $subtotal + ($extra->serviceitem->rate * $extra->quantity);
						}
					}

					echo $strextra;
				?>

			</tbody>
			<?php
				$pajak = $subtotal * $tax->room/100;
			?>
			<tfooter>
				<tr>
					<td></td>
					<td class="text-right"><span style="display:block; margin-right:50px">Subtotal</span></td>
					<td><?= $tax->currency ?></td>
					<td class="text-right"><?= number_format($subtotal) ?></td>
					<td></td>
					<td></td>
				</tr>

				<tr>
					<td></td>
					<td class="text-right"><span style="display:block; margin-right:50px">Pajak</span></td>
					<td><?= $tax->currency ?></td>
					<td class="text-right"><?= number_format($pajak) ?></td>
					<td></td>
					<td></td>
				</tr>

				<tr>
					<td></td>
					<td class="text-right"><span style="display:block; margin-right:50px">Cas</span></td>
					<td><?= $tax->currency ?></td>
					<td class="text-right"><?= number_format($charge) ?></td>
					<td></td>
					<td></td>
				</tr>

				<tr style="border-bottom: 2px solid #ddd;">
					<td></td>
					<td class="text-right"><span style="display:block; margin-right:50px">Diskon</span></td>
					<td></td>
					<td></td>
					<td><?= $tax->currency ?></td>
					<td class="text-right">0</td>
				</tr>

				<tr>
					<td></td>
					<td class="text-right"><b><span style="display:block; margin-right:50px">Total</span></b></td>
					<td><b><?= $tax->currency ?></b></td>
					<td class="text-right"><b><?= number_format($subtotal+$pajak+$charge) ?></b></td>
					<td></td>
					<td></td>
				</tr>

				<tr style="border-bottom: 2px solid #ddd;">
					<td></td>
					<td class="text-right"><span style="display:block; margin-right:50px">Bayar</span></td>
					<td></td>
					<td></td>
					<td><?= $tax->currency ?></td>
					<td class="text-right"><?= number_format($payment->amountpaid) ?></td>
				</tr>

				<tr>
					<td></td>
					<td class="text-right"><span style="display:block; margin-right:50px">Sisa</span></td>
					<td><?= $tax->currency ?></td>
					<td class="text-right"><?= number_format($payment->amountpaid - ($subtotal+$pajak+$charge)) ?></td>
					<td></td>
					<td></td>
				</tr>
				
			</tfooter>
		</table>
	</div>

	<div style="font-size:18px !important; margin-bottom:15px">
		<p>Saya setuju bahwa saya secara pribadi bertanggung jawab atas pembayaran di atas.</p>
		<p><i>I agree that I am personally liable for the payment of the above statement.</i></p>
	</div>

	<div style="font-size:16px !important; margin-bottom:15px; padding-top:100px">
		_____________________________________________<br>
		<span style="margin-left:35px">T.t.d Tamu / <i>Guest Signature</i></span>
	</div>

	<div style="font-size:18px !important; text-align:center">
		<i>Have a pleasure stay at Dyva Hotel. Thank you.</i>
	</div>
	</td>
</tr>
</tbody>
<tfooter>
<tr>
<td>
<div style="display: block;bottom: 0;text-align:center">
	HOTEL DYVA . 
	Tel:<?= $hotel->phone1 . ($hotel->phone2 == '' ? '' : ' / ' . $hotel->phone2) ?> . 
	E-mail: <?= $hotel->email ?> . 
	Fax: <?= $hotel->fax ?> <br>

	<?= $hotel->address ?> . 
	<?= $hotel->city ?> . 
	<?= $hotel->state ?> . 
	<?= $hotel->location->name ?>
</div>
</td>
</tr>
</tfooter>
</body>
</html>
<script>
window.print();
</script>
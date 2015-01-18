<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\tabs\TabsX;

/* @var $this yii\web\View */
/* @var $model app\models\Payment */

$this->title = $model->customer->name . ' @' . date('d-M-Y', strtotime($model->date));
$this->params['breadcrumbs'][] = ['label' => 'Payments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Print', ['print-payment', 'paymentid' => $model->paymentid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->paymentid], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    
    <?php
        
        $extra_str = '<table class="table table-striped table-bordered">';
        $extra_str = $extra_str . '<thead><th>Date</th><th>Service</th><th>Quantity</th></thead>';

        $room_str = '<table class="table table-striped table-bordered">';
        $room_str = $room_str . '<thead><th>Date</th><th>Service</th><th>Check out</th></thead>';
        
        foreach($model->roomreservations as $room){
            $room_str = $room_str . '<tr>'.
                '<td>'.date('d.M.Y', strtotime($room->startdate)).' - '.date('d.M.Y', strtotime($room->enddate)).'</td>'.
                '<td>Akomodasi '.$room->room->name.' - '.$room->room->roomtype->name.'</td>'.
                '<td>'.date('d.M.Y', strtotime($room->out)).'</td>'.
            '</tr>';

            foreach($room->extraservices as $extra){
                $extra_str = $extra_str . '<tr>'.
                    '<td>'.date('d-M-Y, H:i', strtotime($extra->date)).'</td>'.
                    '<td>'.$extra->serviceitem->name.'</td>'.
                    '<td>'.$extra->quantity.'</td>'.
                '</tr>';
            }
        };

        $room_str = $room_str . '</table>';
        $extra_str = $extra_str . '</table>';

        $items = [
            [
                'label'=>'<img height="20px" src="'.\Yii::$app->request->BaseUrl.'/img/payment.png"/> Payment',
                'content'=>DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'customer.name',
                        [
                            'attribute'=>'date',
                            'value'=>date('d-M-Y', strtotime($model->date))
                        ],
                        [
                            'attribute'=>'amountpaid',
                            'value'=>\app\models\Tax::find()->orderBy('taxid desc')->one()->currency . ' ' . number_format($model->amountpaid)
                        ],
                    ],
                ]),
                'active'=>true
            ],
            [
                'label'=>'<img height="20px" src="'.\Yii::$app->request->BaseUrl.'/img/reservation.png"/> Room Reservation',
                'content'=>$room_str,                
            ],
            [
                'label'=>'<img height="20px" src="'.\Yii::$app->request->BaseUrl.'/img/service.png"/> Extra Service',
                'content'=>$extra_str,
            ],
        ];

        echo TabsX::widget([
            'items'=>$items,
            'position'=>TabsX::POS_ABOVE,
            'bordered'=>true,
            'encodeLabels'=>false
        ]);

    ?>

</div>

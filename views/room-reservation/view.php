<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\tabs\TabsX;

/* @var $this yii\web\View */
/* @var $model app\models\RoomReservation */

$this->title = $model->room->name;
$this->params['breadcrumbs'][] = ['label' => 'Room Reservations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="room-reservation-view">

    <h1>
        <img height="50px" src="<?=\Yii::$app->request->BaseUrl?>/img/reservation.png"/>
        <span style="vertical-align: middle;">Room Reservations: <?= Html::encode($this->title) ?></span></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->roomreservationid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Add Extra Service', ['extra-service/create', 'id' => $model->roomreservationid], ['class' => 'btn btn-primary']) ?>
    </p>

    <?php
        
        $extra = \app\models\ExtraService::find()->where('roomreservationid = :1', [':1'=>$model->roomreservationid])->all();
        $extraStr = '<table class="table table-striped table-bordered">';
        $extraStr = $extraStr . '<thead><th>Item</th><th>Rate</th><th>Quantity</th><th>Date</th><th></th></thead>';
        for($i = 0; $i < count($extra); $i++){
            $extraStr = $extraStr .'<tr><td>'. $extra[$i]->serviceitem->name . '</td>'.
                '<td>'. str_replace(',', '.', number_format($extra[$i]->serviceitem->rate)) . '</td>'.
                '<td>'. $extra[$i]->quantity . '</td>'.
                '<td>'. date("d-M-Y, H:i", strtotime($extra[$i]->date)) . '</td>'.
                '<td>'.Html::a('<i class="glyphicon glyphicon-pencil"></i>', ['extra-service/update', 'id' => $extra[$i]->extraserviceid]). ' '.
                    Html::a('<i class="glyphicon glyphicon-trash"></i>', ['extra-service/delete', 'id' => $extra[$i]->extraserviceid, 'roomreservation'=> $model->roomreservationid], [
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],
                    ]).'</td></tr>';
        }
        if (count($extra) < 1){
            $extraStr = $extraStr . '<tr><td colspan="5" class="text-center">No extra services</td></tr>';
        }
        $extraStr = $extraStr . '</table>';

        $items = [
            [
                'label'=>'<img height="20px" src="'.\Yii::$app->request->BaseUrl.'/img/reservation.png"/> Room Reservation',
                'content'=>
                            DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    [
                                        'attribute' => 'roomid',
                                        'value' => $model->room->name],
                                    [
                                        'attribute' => 'customerid',
                                        'value' => $model->customer->name],
                                    'adult',
                                    'child',
                                    [
                                        'attribute' => 'startdate',
                                        'label' => 'Start Date',
                                        'value'=>date('d-M-Y', strtotime($model->startdate))],
                                    [
                                        'attribute' => 'enddate',
                                        'label' => 'End Date',
                                        'value'=>date('d-M-Y', strtotime($model->enddate))],
                                    [
                                        'attribute' => 'deposit',
                                        'value' => str_replace(',', '.', number_format($model->deposit))],
                                    [
                                        'attribute' => 'cancel',
                                        'value' => $model->cancel == 'Y' ? 'Yes' : 'No' ],
                                    [
                                        'attribute' => 'roomstatusid',
                                        'value' => $model->roomStatusText,
                                        'format' => 'html'],
                                ],
                            ]),
                'active'=>true
            ],
            [
                'label'=>'<img height="20px" src="'.\Yii::$app->request->BaseUrl.'/img/service.png"/> Extra Service',
                'content'=>$extraStr
                    
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
<style>
    .tab-content{
        min-height:250px;
    }
</style>
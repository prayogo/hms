<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RoomReservation */

$this->title = 'Update';
$this->params['breadcrumbs'][] = ['label' => 'Room Reservations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->room->name, 'url' => ['view', 'id' => $model->roomreservationid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="room-reservation-update">

    <h1>
        <img height="50px" src="<?=\Yii::$app->request->BaseUrl?>/img/reservation.png"/>
        <span style="vertical-align: middle;">Room Reservations: <?= Html::encode($this->title) ?></span></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

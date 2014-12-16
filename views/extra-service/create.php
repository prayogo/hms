<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ExtraService */
$model->roomreservationid = isset($_GET['id']) ? $_GET['id'] : 0;


$this->title = 'Create Extra Service';
$this->params['breadcrumbs'][] = ['label' => 'Room Reservations', 'url' => ['room-reservation/index']];
$this->params['breadcrumbs'][] = ['label' => $model->roomreservation->room->name, 'url' => ['room-reservation/view', 'id'=>$model->roomreservationid]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="extra-service-create">

    <h1>
        <img height="50px" src="<?=\Yii::$app->request->BaseUrl?>/img/reservation.png"/>
        <span style="vertical-align: middle;">Room Reservations: <?= Html::encode($this->title) ?></span></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

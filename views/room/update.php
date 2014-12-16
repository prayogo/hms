<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Room */

$this->title = 'Update';
$this->params['breadcrumbs'][] = ['label' => 'Rooms', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->roomid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="room-update">

    <h1>
        <img height="50px" src="<?=\Yii::$app->request->BaseUrl?>/img/room.png"/>
        <span style="vertical-align: middle;">Rooms: <?= Html::encode($this->title) ?></span></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

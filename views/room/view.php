<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Room */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Rooms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="room-view">

    <h1>
        <img height="50px" src="<?=\Yii::$app->request->BaseUrl?>/img/room.png"/>
        <span style="vertical-align: middle;">Rooms: <?= Html::encode($this->title) ?></span></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->roomid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->roomid], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'lockid',
            'description',
            [
                'attribute'=>'floorid',
                'value'=>$model->floor->name
            ],
            [
                'attribute'=>'roomtypeid',
                'value'=>$model->roomtype->name
            ],
            [
                'attribute'=>'roomstatusid',
                'format' => 'html',
                'value'=>$model->roomstatusColor
            ],
        ],
    ]) ?>

</div>

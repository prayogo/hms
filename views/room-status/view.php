<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\RoomStatus */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Room Status', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="room-status-view">

    <h1>
        <img height="50px" src="<?=\Yii::$app->request->BaseUrl?>/img/status.png"/>
        <span style="vertical-align: middle;">Room Status: <?= Html::encode($this->title) ?></span></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->roomstatusid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->roomstatusid], [
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
            [
                'attribute'=>'colorHtml',
                'type'=>'raw',
                'format' => 'html'
            ]
        ],
    ]) ?>

</div>

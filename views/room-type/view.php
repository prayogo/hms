<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\RoomType */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Room Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="room-type-view">

    <h1>
        <img height="50px" src="<?=\Yii::$app->request->BaseUrl?>/img/roomtype.png"/>
        <span style="vertical-align: middle;">Room Types: <?= Html::encode($this->title) ?></span></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->roomtypeid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->roomtypeid], [
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
            'singleb',
            'doubleb',
            'extrab',
            'maxchild',
            'maxadult',
            'ChildChargeFormat',
            'AdultChargeFormat',
            'description',
            'RateChargeFormat',
            'WeekEndChargeFormat',
            'EquipmentText'
        ],
    ]) ?>

</div>

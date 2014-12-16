<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\SeasonalRateDetail */

$this->title = $model->seasonalratedetailid;
$this->params['breadcrumbs'][] = ['label' => 'Seasonal Rate Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seasonal-rate-detail-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->seasonalratedetailid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->seasonalratedetailid], [
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
            'seasonalratedetailid',
            'seasonalrateid',
            'roomid',
        ],
    ]) ?>

</div>

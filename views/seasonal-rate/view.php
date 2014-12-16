<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\SeasonalRate */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Seasonal Rates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seasonal-rate-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->seasonalrateid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->seasonalrateid], [
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
            'seasonalrateid',
            'name',
            'description',
            'startdate',
            'enddate',
            'mon',
            'tue',
            'wed',
            'thu',
            'fri',
            'sat',
            'sun',
        ],
    ]) ?>

</div>

<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SeasonalRateDetail */

$this->title = 'Update Seasonal Rate Detail: ' . ' ' . $model->seasonalratedetailid;
$this->params['breadcrumbs'][] = ['label' => 'Seasonal Rate Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->seasonalratedetailid, 'url' => ['view', 'id' => $model->seasonalratedetailid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="seasonal-rate-detail-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

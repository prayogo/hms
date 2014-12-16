<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SeasonalRateDetail */

$this->title = 'Create Seasonal Rate Detail';
$this->params['breadcrumbs'][] = ['label' => 'Seasonal Rate Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seasonal-rate-detail-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

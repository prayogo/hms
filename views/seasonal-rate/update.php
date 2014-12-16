<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SeasonalRate */

$this->title = 'Update Seasonal Rate: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Seasonal Rates', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->seasonalrateid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="seasonal-rate-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SeasonalRate */

$this->title = 'Create Seasonal Rate';
$this->params['breadcrumbs'][] = ['label' => 'Seasonal Rates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seasonal-rate-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

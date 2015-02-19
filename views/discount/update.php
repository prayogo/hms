<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Discount */

$this->title = 'Update Discount: ' . ' ' . $model->discountid;
$this->params['breadcrumbs'][] = ['label' => 'Discounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->discountid, 'url' => ['view', 'id' => $model->discountid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="discount-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

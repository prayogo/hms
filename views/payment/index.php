<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PaymentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Payments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Payment', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute'=>'customerid',
                'value'=>'customer.name'
            ],
            [
                'attribute'=>'date',
                'value'=>'dateText'
            ],
            [
                'attribute'=>'amountpaid',
                'value'=>'numberFormat'
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{view} {delete}'
            ],
        ],
    ]); ?>

</div>

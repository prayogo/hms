<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SeasonalRateDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Seasonal Rate Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seasonal-rate-detail-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Seasonal Rate Detail', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'seasonalratedetailid',
            'seasonalrateid',
            'roomid',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>

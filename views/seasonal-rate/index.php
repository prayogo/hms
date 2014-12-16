<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SeasonalRateSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Seasonal Rates';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seasonal-rate-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Seasonal Rate', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'seasonalrateid',
            'name',
            'description',
            'startdate',
            'enddate',
            // 'mon',
            // 'tue',
            // 'wed',
            // 'thu',
            // 'fri',
            // 'sat',
            // 'sun',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>

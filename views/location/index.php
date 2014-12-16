<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LocationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Locations';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="location-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Location', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'contentOptions'=>['style'=>'width: 70px;']
            ],

            [
                'attribute'=>'locationid',
                'contentOptions'=>['style'=>'width: 100px;']
            ],
            [
                'attribute'=>'iso2',
                'contentOptions'=>['style'=>'width: 100px;']
            ],
            'name',

            [
                'class' => 'yii\grid\ActionColumn',
                'contentOptions'=>['style'=>'width: 100px;']
            ],
        ],
    ]); ?>

</div>

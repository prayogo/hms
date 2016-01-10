<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RoomTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Room Types';
$this->params['breadcrumbs'][] = $this->title;
?>

        

    



<section class="content-header">
  <h1><?= Html::encode($this->title) ?></h1>
  <?= yii\widgets\Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
  ]) ?>
</section>

<section class="content">
    <div class="box box-default">
        <div class="box-header with-border">
            <?= Html::a('Create Room Type', ['create'], ['class' => 'btn btn-success']) ?>
        </div>
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'contentOptions'=>['style'=>'width: 70px;']
                    ],

                    [
                        'attribute'=>'name',
                        'contentOptions'=>['style'=>'width: 250px;']
                    ],
                    'singleb',
                    'doubleb',
                    'extrab',
                    'maxchild',
                    'maxadult',
                    //'childcharge',
                    //'adultcharge',
                    // 'description',
                    [
                        'attribute'=>'rate',
                        'value'=>'RateChargeFormat'
                    ],
                    // 'weekendrate',

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'contentOptions'=>['style'=>'width: 100px;']
                    ],
                ],
            ]); ?>
        </div>
    </div>
</section>
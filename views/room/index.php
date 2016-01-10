<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RoomSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Rooms';
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
            <?= Html::a('Create Room', ['create'], ['class' => 'btn btn-success']) ?>
        </div>
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    [
                        'attribute'=>'name',
                        'contentOptions'=>['style'=>'width: 150px;']
                    ],
                    [
                        'attribute'=>'lockid',
                        'contentOptions'=>['style'=>'width: 120px;']
                    ],
                    'description',
                    [
                        'attribute'=>'varfloor',
                        'value'=>'floor.name',
                        'contentOptions'=>['style'=>'width: 130px;']
                    ],
                    [
                        'attribute'=>'varroomtype',
                        'value'=>'roomtype.name',
                        'contentOptions'=>['style'=>'width: 180px;']
                    ],
                    [
                        'attribute'=>'varroomstatus',
                        'value'=>'colorHtml',
                        'format'=>'html',
                        'contentOptions'=>['style'=>'width: 120px;']
                    ],

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>
</section>
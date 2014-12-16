<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RoomSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Rooms';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="room-index">

    <h1>
        <img height="50px" src="<?=\Yii::$app->request->BaseUrl?>/img/room.png"/>
        <span style="vertical-align: middle;"><?= Html::encode($this->title) ?></span></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Room', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

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

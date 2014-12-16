<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RoomTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Room Types';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="room-type-index">

    <h1>
        <img height="50px" src="<?=\Yii::$app->request->BaseUrl?>/img/roomtype.png"/>
        <span style="vertical-align: middle;"><?= Html::encode($this->title) ?></span></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Room Type', ['create'], ['class' => 'btn btn-success']) ?>
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

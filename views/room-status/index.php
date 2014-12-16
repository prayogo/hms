<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RoomStatusSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Room Status';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="room-status-index">

    <h1>
        <img height="50px" src="<?=\Yii::$app->request->BaseUrl?>/img/status.png"/>
        <span style="vertical-align: middle;"><?= Html::encode($this->title) ?></span></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Room Status', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'contentOptions'=>['style'=>'width: 70px;']
            ],

            'name',
            [
                'attribute'=>'colorHtml',
                'contentOptions'=>['style'=>'width: 150px;'],
                'format' => 'html'
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'contentOptions'=>['style'=>'width: 100px;']
            ],
        ],
    ]); ?>

</div>

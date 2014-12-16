<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1>
        <img height="50px" src="<?=\Yii::$app->request->BaseUrl?>/img/user.png"/>
        <span style="vertical-align: middle;"><?= Html::encode($this->title) ?></span></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
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
                'attribute'=>'username',
                'contentOptions'=>['style'=>'width: 200px;']
            ],
            'fullname',
            'displayname',
            [
                'attribute'=>'phone',
                'contentOptions'=>['style'=>'width: 160px;']
            ],
            [
                'attribute'=>'varActive',
                'value'=>'activeText',
                'contentOptions'=>['style'=>'width: 100px;']
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'contentOptions'=>['style'=>'width: 100px;']
            ],
        ],
    ]); ?>

</div>

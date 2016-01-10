<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
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
            <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
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
    </div>
</section>
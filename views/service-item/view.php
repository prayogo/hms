<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ServiceItem */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Service Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="service-item-view">

    <h1>
        <img height="50px" src="<?=\Yii::$app->request->BaseUrl?>/img/service.png"/>
        <span style="vertical-align: middle;">Service Items: <?= Html::encode($this->title) ?></span></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->serviceitemid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->serviceitemid], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            
            'name',
            'rateFormat',
        ],
    ]) ?>

</div>

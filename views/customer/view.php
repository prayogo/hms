<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Customer */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Customers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-view">

    <h1>
        <img height="50px" src="<?=\Yii::$app->request->BaseUrl?>/img/customer.png"/>
        <span style="vertical-align: middle;">Customers: <?= Html::encode($this->title) ?></span></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->customerid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->customerid], [
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
            'address',
            'email:email',
            'npwp',
            [
                'attribute'=>'location.name',
                'label'=>'Location',
            ],
            'birthdateText',
            'comment',
            'blacklistText',
            'phoneText',
            'identificationText',
        ],
    ]) ?>

</div>